import React, { Component } from 'react';
import PropTypes from 'prop-types';
// import { Col, Pagination, PaginationItem, PaginationLink } from 'reactstrap';
// import ChevronLeftIcon from 'mdi-react/ChevronLeftIcon';
// import ChevronRightIcon from 'mdi-react/ChevronRightIcon';
// import { _toConsumableArray } from '../../../utils/ArrayUtil';
import ChevronLeft from '@material-ui/icons/ChevronLeft';
import ChevronRight from '@material-ui/icons/ChevronRight';

import Grid from '@material-ui/core/Grid';


class DataTablePagination extends Component {
  state = {
    pages: this.props.pages,
    pGroups: []
  }

  componentDidMount() {
    this.groupPages();
  }

  componentDidUpdate = prevProps => {
    const { pages } = this.props;
    if (prevProps.pages !== pages) {
      this.setState({
        pages: pages
      }, () => this.groupPages()
      );
    }
  }

  pagesIndexify = () => {
    const { pages } = this.state;

    let mutablePages = [...pages];

    mutablePages.forEach((page, index) => (page.index = index));
    return mutablePages;
  }

  groupPages = () => {
    const pGroups = [];
    const pages = this.pagesIndexify();
    const { pagesAmount } = this.props;

    while (pages.length > 0) {
      pGroups.push(pages.splice(0, pagesAmount));
    }
    this.setState({
      pGroups
    });
  }

  choosePagesGroup = () => {
    const { activePage, pagesAmount } = this.props;
    const { pGroups } = this.state;
    const pGroupNumber = Math.floor(activePage / pagesAmount);
    return pGroups.length ? pGroups[pGroupNumber] : [];
  }

  render() {

    const { activePage, changeActivePage, pages, pagesTotal } = this.props;
    // console.log(activePage);
    return (
      <Grid md={7} sm={12}>
        <div className="dataTables_paginate">
          <div className="pagination">
            <div
              className={`page-item pagination__item${activePage <= 0 ? ' disabled' : ''}`}
            // disabled={activePage <= 0}
            >
              <button
                className="pagination__link pagination__link--arrow page-link"
                onClick={() => changeActivePage(activePage - 1)}
              >
                <ChevronLeft className="pagination__link-icon" />
              </button>
            </div>
            {this.choosePagesGroup().map((page, index) =>
              (<div
                className={`pagination__item page-item${page.index === activePage ? ' active' : ''}`}
                key={Object.keys(page[0])[0] + page.index}
              // active={page.index === activePage}
              // key={index} 
              // active={index === activePage}
              >
                <button
                  className="pagination__link page-link pagination__link--arrow"
                  onClick={() => changeActivePage(page.index)}
                >
                  {page.index + 1}
                </button>
              </div>))}
            <div
              className={`pagination__item page-item${!pages.length || activePage === pages.length - 1 ? ' disabled' : ''}`}
            // disabled={!pages.length || activePage === pages.length - 1}
            >
              <button
                className="pagination__link page-link pagination__link--arrow"
                onClick={() => changeActivePage(activePage + 1)}
              >
                <ChevronRight className="pagination__link-icon" />
              </button>
            </div>
          </div>

        </div>
      </Grid>
    );
  }
}

DataTablePagination.propTypes = {
  activePage: PropTypes.number.isRequired,
  changeActivePage: PropTypes.func.isRequired,
  pages: PropTypes.array.isRequired,
  pagesAmount: PropTypes.number.isRequired,
  pagesTotal: PropTypes.number.isRequired,
};

export default DataTablePagination;