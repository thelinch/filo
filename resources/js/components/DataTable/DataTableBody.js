import React from 'react';
import PropTypes from 'prop-types';
import _get from 'lodash/get';

const renderRows = (columns, rows) => {
  return rows.map((record, index) => (
    <tr className="text-center" key={record.id}>{columns.map(col => {
      const { dataIndex, render, title } = col;
      let text = void 0;
      if (typeof dataIndex === 'number') {
        text = _get(record, dataIndex);
      } else if (!dataIndex || dataIndex.length === 0) {
        text = record;
      } else {
        text = _get(record, dataIndex);
      }

      if (render) {
        text = render(text, record, index);
      }

      return <td key={title}>{text}</td>
    })}</tr>
  ))
}
const renderNoData = columns => {
  return <tr><td colSpan={columns.length} className="text-center">No hay datos</td></tr>
}

const DataTableBody = props => {
  const { columns, rows } = props;
  // console.log(rows);
  return (
    <tbody>
      {rows && rows.length > 0 ? renderRows(columns, rows) : renderNoData(columns)}
    </tbody>
  );
};

DataTableBody.propTypes = {

};

export default DataTableBody;