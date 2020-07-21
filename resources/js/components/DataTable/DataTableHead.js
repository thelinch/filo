import React from 'react';
import PropTypes from 'prop-types';
import ExpandLess from '@material-ui/icons/ExpandLess';
import ExpandMore from "@material-ui/icons/ExpandMore"
// import MenuUpIcon from 'mdi-react/MenuUpIcon';
// import MenuDownIcon from 'mdi-react/MenuDownIcon';

const DataTableHead = ({ columns, handleSort, sortable }) => {
  return (
    <thead>
      <tr>
        {
          columns.map((col, index) =>
            <th style={{ cursor: "pointer" }}
              key={index}
              onClick={function onClick() { return sortable && handleSort(col.dataIndex, col.sort) }}
            >
              {col.title}
              {sortable && col.sort !== 'disabled' && col.sort === 'asc' ? <ExpandLess className="float-right" /> : <ExpandMore className='float-right' />}
            </th>)
        }
      </tr>
    </thead>
  );
};

DataTableHead.propTypes = {
  columns: PropTypes.arrayOf(PropTypes.object),
  handleSort: PropTypes.func,
  sortable: PropTypes.bool,
};

DataTableHead.defaultProps = {
  sortable: true
}
export default DataTableHead;