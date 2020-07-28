import React from 'react';
import PropTypes from 'prop-types';
import moment from 'moment';

export class CalendarHeader extends React.Component {
  shouldComponentUpdate(nextProps) {
    // for columnDimensions return new object
    return nextProps.columnDimensions !== this.props.columnDimensions;
  }

  render() {
    const {
      columnDimensions,
      weekdays
    } = this.props;


    if (columnDimensions.length === 0) {
      return null;
    }
    // const weekdays = moment.weekdays();

    let totalWidth = 0;
    const weekdaycolumns = weekdays.map((day, i)=> {
        const { width } = columnDimensions[i];
        totalWidth += width;
        return (
            <div className="week-calendar-header-column" key={day.id} style={{ width }}>
                <span className="title">{day.day}</span>
            </div>
        );
    });

    return (
        <div className="week-calendar-header-wrapper" style={{ width: totalWidth }}>
            {weekdaycolumns}
        </div>
    );
  }
}

CalendarHeader.propTypes = {

};

export default CalendarHeader;
