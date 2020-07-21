import React from 'react';
import PropTypes from 'prop-types';
import Grid from '@material-ui/core/Grid';


const DataTableSearch = ({ handleSearchChange, search, searching }) => {
  return (
    <Grid item md={6} sm={12}>
      {
        searching &&
        <div className="dataTables_filter">
          <label>Buscar:
            <input
              className="form-control form-control-sm"
              value={search}
              onChange={handleSearchChange}
              type='search'
              placeholder='Buscar'
            />
          </label>

        </div>
      }
    </Grid>
  );
};

DataTableSearch.propTypes = {
  handleSearchChange: PropTypes.func.isRequired,
  search: PropTypes.string.isRequired,
  searching: PropTypes.bool.isRequired,
}
export default DataTableSearch;