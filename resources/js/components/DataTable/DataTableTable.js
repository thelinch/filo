import React from 'react';
import PropTypes from 'prop-types';
// import { Table } from 'reactstrap';
import DataTableHead from './DataTableHead';
import DataTableBody from './DataTableBody';

const DataTableTable = (props) => {
  const {
    autoWidth,
    btn,
    columns,
    hover,
    small,
    responsive,
    handleSort,
    sortable,
    sorted,
    rows
  } = props;
  return (
    <div className="table-responsive">
      <table className="table-bordered table table-hover" style={{ width: "100%" }}>
        <DataTableHead
          columns={columns}
          handleSort={handleSort}
          sortable={sortable}
          sorted={sorted}
        />
        <DataTableBody
          columns={columns}
          rows={rows}
        />
      </table>
    </div>
  );
};

DataTableTable.propTypes = {

};

export default DataTableTable;