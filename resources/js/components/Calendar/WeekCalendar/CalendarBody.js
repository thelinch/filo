import React from 'react';
import PropTypes from 'prop-types';
import moment from 'moment';

import DayColumn from './DayColumn';
import { getDayIntervals } from '../../../util/calendar';

const propTypes = {
//   numberOfDays: PropTypes.number.isRequired,
//   scaleUnit: PropTypes.number.isRequired,
//   scaleIntervals: PropTypes.array.isRequired,
//   cellHeight: PropTypes.number.isRequired,
//   dayCellComponent: PropTypes.func.isRequired,
//   onSelectionStart: PropTypes.func.isRequired,
//   onCellMouseEnter: PropTypes.func.isRequired,
};

class CalendarBody extends React.Component {
//   shouldComponentUpdate(nextProps) {
//     return nextProps.scaleUnit !== this.props.scaleUnit
//       || nextProps.cellHeight !== this.props.cellHeight
//       || nextProps.numberOfDays !== this.props.numberOfDays
//       || !nextProps.firstDay.isSame(this.props.firstDay, 'day');
//   }

  render() {
    const {
        scaleUnit,
        scaleIntervals,
        cellHeight
    } = this.props;

    const weekdays = moment.weekdays();

    const weekdayColumns = weekdays.map((day, i )=> {
        const intervals = getDayIntervals(day, scaleIntervals);
        return (
            <DayColumn 
                key={i}
                colPos={i}
                cellHeight={cellHeight}
                scaleUnit={scaleUnit}
                dayIntervals={intervals}
                onSelectionStart={this.props.onSelectionStart}
                onCellMouseEnter={this.props.onCellMouseEnter}
            />
        )
    })

    return (
        <div className="calendar-body" >
            <div className="calendar-body-row">
                {weekdayColumns}
            </div>
        </div>
    );
  }
}

CalendarBody.propTypes = propTypes;

export default CalendarBody;
