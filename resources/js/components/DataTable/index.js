import React, { Component } from 'react';
import PropTypes from 'prop-types';
import DataTableEntries from './DataTableEntries';
import DataTableSearch from './DataTableSearch';
import DataTableInfo from './DataTableInfo';
import DataTablePagination from './DataTablePagination';
import DataTableTable from './DataTableTable';
import _get from 'lodash/get';
import Grid from '@material-ui/core/Grid';

class DataTable extends Component {
  state = {
    activePage: 0,
    columns: this.props.columns || [],
    entries: this.props.entries,
    filteredRows: this.props.data || [],
    order: this.props.order || [],
    pages: [],
    pagesTotal: 0,
    rows: this.props.data || [],
    search: '',
    sorted: false,
    unsearchable: []
  }

  componentDidMount() {
    const { paging } = this.props;
    const { order, columns, pages, rows } = this.state;
    if (order.length > 0) {
      this.handleSort(order[0], order[1]);
    } else {
      this.handleSort()
    }
    this.setUnsearchable(columns);

    if (paging) {
      this.paginateRowsInitialy();
    } else {
      pages.push(rows);
    }
  }

  componentDidUpdate(prevProps, prevState) {
    const { data } = this.props;
    if (prevProps.data !== data) {
      this.setState({
        filteredRows: data,
        rows: data,
      }, () => this.paginateRows());
      // }, () => this.filterRows());
      this.filterRows();
    }
  }
  setUnsearchable = columns => {
    const unsearchable = [];

    columns.forEach(column => {
      if (column.searchable !== undefined && column.searchable === false) {
        unsearchable.push(column.dataIndex);
      }
    });

    this.setState({ unsearchable });
  };

  pagesAmount = () => {
    return Math.ceil(this.state.filteredRows.length / this.state.entries);
  }

  paginateRowsInitialy = () => {
    const { rows, entries, pages } = this.state;

    const pagesAmount = this.pagesAmount();

    for (let i = 1; i <= pagesAmount; i++) {
      const pageEndIndex = i * entries;
      pages.push(rows.slice(pageEndIndex - entries, pageEndIndex));
    }
    // this.setState({
    //   pages: pages
    // })
  }

  handleEntriesChange = (value) => {
    this.setState({
      entries: Array.isArray(value) ? value[0] : value
    }, () => this.paginateRows());
  }

  handleSearchChange = (e) => {
    this.setState({
      search: e.target.value
    }, () => this.filterRows());
  }

  checkFieldValue = (array, field) => {
    return array[field] && typeof array[field] !== 'string'
      ? array[field].props.searchvalue
      : array[field];
  };

  checkField = (field, a, b, direction) => {
    const [aField, bField] = [
      this.checkFieldValue(a, field),
      this.checkFieldValue(b, field)
    ];

    let comp = aField > bField ? -1 : 1;
    if (direction === 'asc') {
      comp *= -1;
    }

    return comp;
  };

  sort = (rows, sortRows, field, direction) => {
    rows.sort((a, b) => {
      if (sortRows && sortRows.includes(field)) {
        return this.checkField(field, a, b, direction);
      }

      return direction === 'asc'
        ? a[field] < b[field]
          ? -1
          : 1
        : a[field] > b[field]
          ? -1
          : 1;
    });
  };
  handleSort = (field, sort) => {
    if (sort === "disabled") return;

    this.setState(
      prevState => {
        const { sortRows } = this.props;
        const { rows, columns } = prevState;
        const direction = sort === 'desc' ? 'desc' : 'asc';

        this.sort(rows, sortRows, field, direction);

        columns.forEach(col => {
          if (col.sort === 'disabled') {
            return;
          }
          col.sort =
            col.dataIndex === field ? (col.sort === 'desc' ? 'asc' : 'desc') : '';
        });

        return {
          rows,
          columns,
          sorted: true
        };
      },
      () => this.filterRows()
    );
  }

  filterRows = (search = this.state.search) => {
    const { unsearchable } = this.state;
    const { sortRows, noRecordsFoundLabel } = this.props;

    this.setState(
      prevState => {
        const filteredRows = prevState.rows.filter(row => {
          for (const key in row) {
            if (
              (!unsearchable.length || !unsearchable.includes(key)) &&
              typeof row[key] !== 'function'
            ) {
              let stringValue = '';

              if (sortRows && typeof row[key] !== 'string') {
                const content = [];
                const getContent = element =>
                  typeof element === 'object'
                    ? element.props.children &&
                    Array.from(element.props.children).map(el =>
                      getContent(el)
                    )
                    : content.push(element);

                getContent(row[key]);
                stringValue = content.join('');
              } else if (row[key]) {
                stringValue = row[key].toString();
              }
              if (stringValue.toLowerCase().includes(search.toLowerCase())) {
                return true;
              }
            }
          }
          return false;
        });
        // if(filteredRows.length === 0) {
        //   filteredRows.push({
        //     message: noRecordsFoundLabel,
        //     colspan: prevState.columns.length
        //   })
        // }
        let test = {};
        if (this.props.disableRetreatAfterSorting) {
          test = {
            filteredRows,
            activePage: (prevState.activePage =
              prevState.activePage < prevState.pages.length ||
                prevState.activePage === 0
                ? prevState.activePage
                : prevState.pages.length - 1)
          };
        } else if (!this.props.disableRetreatAfterSorting) {
          test = { filteredRows, activePage: 0 };
        }
        return test;
      }, () => this.paginateRows())
  }

  paginateRows = () => {
    let pagesAmount = this.pagesAmount();

    this.setState(prevState => {

      let { pages, entries, filteredRows, activePage } = prevState;
      const { paging, disableRetreatAfterSorting } = this.props;

      pages = [];

      if (paging) {
        for (let i = 1; i <= pagesAmount; i++) {
          const pageEndIndex = i * entries;
          pages.push(filteredRows.slice(pageEndIndex - entries, pageEndIndex));
        }
        if (!disableRetreatAfterSorting) {
          activePage =
            activePage < pages.length || activePage === 0
              ? activePage
              : pages.length - 1;
        }
      } else {
        pages.push(filteredRows);
        activePage = 0;
      }
      return { pages, filteredRows, activePage };
    })
  }

  changeActivePage = (page) => {
    this.setState({
      activePage: page
    })
    // this.setState({
    //   activePage: page
    // }, () => this.paginateRows())
  }

  render() {
    const {
      displayEntries,
      entriesOptions,
      exportToCSV,
      info,
      order,
      pagesAmount,
      paging,
      responsive,
      searching,
      sortable,
      small
    } = this.props;

    const {
      columns,
      entries,
      filteredRows,
      pages,
      activePage,
      search,
      pagesTotal,
      sorted
    } = this.state;
    return (
      <div className="dataTables_wrapper">
        <Grid container>
          <DataTableEntries
            paging={paging}
            displayEntries={displayEntries}
            entries={entries}
            handleEntriesChange={this.handleEntriesChange}
            entriesArr={entriesOptions}
          />
          <DataTableSearch
            handleSearchChange={this.handleSearchChange}
            search={search}
            searching={searching}
          />
        </Grid>
        <DataTableTable
          columns={columns}
          handleSort={this.handleSort}
          rows={pages[activePage]}
          sortable={sortable}
          sorted={sorted}
        />
        <Grid container>
          <DataTableInfo
            activePage={activePage}
            entries={entries}
            filteredRows={filteredRows}
            info={info}
            pages={pages}
          />
          <DataTablePagination
            activePage={activePage}
            changeActivePage={this.changeActivePage}
            pages={pages}
            pagesAmount={pagesAmount}
            pagesTotal={pagesTotal}
          />
        </Grid>
      </div>
    );
  }
}

DataTable.propTypes = {
  columns: PropTypes.arrayOf(PropTypes.object),
  data: PropTypes.arrayOf(PropTypes.object),
  displayEntries: PropTypes.bool,
  entries: PropTypes.number,
  entriesOptions: PropTypes.arrayOf(PropTypes.number),
  exportToCSV: PropTypes.bool,
  info: PropTypes.bool,
  order: PropTypes.arrayOf(PropTypes.string),
  pagesAmount: PropTypes.number,
  paging: PropTypes.bool,
  responsive: PropTypes.bool,
  searching: PropTypes.bool,
  sortable: PropTypes.bool,
  sortRows: PropTypes.arrayOf(PropTypes.string),
  noRecordsFoundLabel: PropTypes.string,
  disableRetreatAfterSorting: PropTypes.bool,
};

DataTable.defaultProps = {
  columns: [],
  data: [],
  displayEntries: true,
  entries: 10,
  entriesOptions: [10, 20, 50, 100],
  exportToCSV: false,
  info: true,
  order: [],
  pagesAmount: 8,
  paging: true,
  responsive: false,
  searching: true,
  sortable: true,
  noRecordsFoundLabel: 'No se encontraron registros',
  disableRetreatAfterSorting: false,
};

export default DataTable;