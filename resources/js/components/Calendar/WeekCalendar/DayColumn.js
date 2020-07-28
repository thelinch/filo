import React from 'react';
import PropTypes from 'prop-types';
import DayCell from './DayCell';

const propTypes = {
//   colPos: PropTypes.number.isRequired,
//   dayIntervals: PropTypes.array.isRequired,
//   cellHeight: PropTypes.number.isRequired,
//   dayCellComponent: PropTypes.func.isRequired,
//   onSelectionStart: PropTypes.func.isRequired,
//   onCellMouseEnter: PropTypes.func.isRequired,
};

class DayColumn extends React.Component {
  handleMouseEnter = (col, row) => () => {
    this.props.onCellMouseEnter(col, row);
  }

  handleStartSelection = (col, row) => () => {
    this.props.onSelectionStart(col, row);
  }

  render() {
    const { colPos, dayIntervals, cellHeight } = this.props;
    // const DayCell = this.props.dayCellComponent;

    const dayCells = dayIntervals.map((interval, rowPos) => (
      <div
        key={rowPos}
        className="calendar-body-cell"
        style={{ height: cellHeight }}
        onMouseEnter={this.handleMouseEnter(colPos, rowPos)}
      >
        <DayCell
          colPos={colPos}
          rowPos={rowPos}
        //   startTime={interval.start}
        //   endTime={interval.end}
          startSelection={this.handleStartSelection(colPos, rowPos)}
        />
      </div>
    ));

    return (
      <div className="calendar-body-column" data-colpos={colPos}>{dayCells}</div>
    );
  }
}

DayColumn.propTypes = propTypes;
export default DayColumn;
