import React from 'react';
import PropTypes from 'prop-types';
import Grid from '@material-ui/core/Grid';

const DataTableEntries = ({ handleEntriesChange, paging, displayEntries, entriesArr, entries }) => {
  const getValue = e => {
    let value = parseInt(e.target.value, 10);
    handleEntriesChange(value);
  }
  return (
    <Grid item md={6} sm={12}>
      {
        paging && displayEntries &&
        <div className='dataTables_length bs-select'>
          <label>
            Ver
            <select className="select-options form-control-sm" value={entries} onChange={getValue}>
              {
                entriesArr.map(entry => <option key={entry} value={entry}>{entry}</option>)
              }
            </select>
          </label>
        </div>
      }
    </Grid>
  );
};

DataTableEntries.propTypes = {
  handleEntriesChange: PropTypes.func.isRequired,
  displayEntries: PropTypes.bool.isRequired,
  entriesArr: PropTypes.arrayOf(PropTypes.number).isRequired,
  paging: PropTypes.bool.isRequired,
  entries: PropTypes.number.isRequired,
}
export default DataTableEntries;