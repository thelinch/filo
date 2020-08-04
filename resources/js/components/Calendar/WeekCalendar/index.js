import React, { Component } from 'react';
import PropTypes from 'prop-types';
import moment from 'moment';
import CalendarBody from './CalendarBody';
import CalendarHeader from './CalendarHeader';
import Event from './Event';
// import { getIntervalsByDuration } from '../../../util/calendar';
import { getIntervalsByDuration, getOffset, getNumberOfCells, getMoment, getIntervals } from '../../../util/calendar';

moment.locale('es');

class WeekCalendar extends Component {
  constructor(props) {
    super(props);
    const { scaleUnit, inithour, endhour } = this.props;
    const scaleIntervals = getIntervalsByDuration(scaleUnit, inithour, endhour);
    this.state = {
      scaleIntervals,
      columnDimensions: [],
      scrollPosition: {
        top: 0,
        left: 0,
      },
      mousePosition: {
        x: 0,
        y: 0
      },
      startSelectionPosition: null,
      preselectedInterval: null,
    }
  }
  componentDidMount() {
    this.calculateColumnDimension();
    window.addEventListener('resize', this.calculateColumnDimension);
    window.addEventListener('mouseup', this.handleSelectionStop);
  }
  componentDidUpdate(nextProps) {
    if (nextProps.scaleUnit !== this.props.scaleUnit || nextProps.inithour !== this.props.inithour || nextProps.endhour !== this.props.endhour) {
      const scaleIntervals = getIntervalsByDuration(nextProps.scaleUnit, nextProps.inithour, nextProps.endhour);
      this.setState({
        scaleIntervals,
      });
    }
  }
  componentWillUnmount() {
    window.removeEventListener('resize', this.calculateColumnDimension);
    window.removeEventListener('mouseup', this.handleSelectionStop);
  }
  calculateColumnDimension = () => {
    const {
      numberOfDays,
    } = this.props;
    const columnDimensions = [];
    for (let i = 0; i < numberOfDays; i += 1) {
      const left = (i === 0) ? 0 : (columnDimensions[i - 1].left + columnDimensions[i - 1].width);
      let columnWidth = 0;

      const columnElement = document.querySelectorAll(`[data-colpos='${i}']`)[0];
      if (columnElement) {
        columnWidth = columnElement.getBoundingClientRect().width;
      }
      columnDimensions.push({
        left,
        width: columnWidth,
      });
    }
    this.setState({ columnDimensions });
  }
  handleScroll = (e) => {
    this.setState({
      scrollPosition: {
        top: e.target.scrollTop,
        left: e.target.scrollLeft,
      },
    });
  }
  handleEventClick = (oEvent) => {
    if (this.props.onEventClick) {
      this.props.onEventClick(oEvent);
    }
    const preselectedInterval = {
      days: [oEvent.day],
      inithour: oEvent.inithour,
      endhour: oEvent.endhour,
    };
    this.props.onIntervalSelect(preselectedInterval, true);

    this.setState({
      preselectedInterval,
      updateEvent: true,
    });
  }

  handleSelectionStop = (e) => {
    if (e.button !== 0) {
      return;
    }

    const {
      inithour,
      scaleUnit,
      weekdays
    } = this.props;
    const {
      startSelectionPosition,
      mousePosition,
    } = this.state;


    if (startSelectionPosition == null) {
      return;
    }

    const endCol = mousePosition.x;
    const endRow = mousePosition.y;

    const minDayIndex = Math.min(startSelectionPosition.x, endCol);
    const maxDayIndex = Math.max(startSelectionPosition.x, endCol);
    let days = [];
    for (let dayIndex = minDayIndex; dayIndex <= maxDayIndex; dayIndex += 1) {
      const day = weekdays[dayIndex];
      days.push({ id: day.id, day: day.day });
    }

    const minCellIndex = Math.min(startSelectionPosition.y, endRow);
    const maxCellIndex = Math.max(startSelectionPosition.y, endRow);
    const offsetTop = getOffset(inithour);
    const startSelectionTime = getMoment(scaleUnit, minCellIndex, offsetTop).format('HH:mm');
    const endSelectionTime = getMoment(scaleUnit, maxCellIndex, offsetTop).format('HH:mm');

    const preselectedInterval = {
      days,
      inithour: startSelectionTime,
      endhour: endSelectionTime,
    };
    this.props.onIntervalSelect(preselectedInterval);
    this.setState({
      preselectedInterval,
      updateEvent: false,
    });


    this.setState({
      startSelectionPosition: null,
      mousePosition: null,
    });
  }

  renderScale = () => {
    const { cellHeight } = this.props;
    const { scaleIntervals, scrollPosition } = this.state;
    const scaleCell = scaleIntervals.map((scaleInterval, index) => {
      return (
        <div key={index} className="week-calendar-scale-cell" style={{ height: cellHeight, lineHeight: `${cellHeight}px` }}>
          <span>{scaleInterval.start}</span>
        </div>
      );
    })
    return (
      <div className="week-calendar-scale-column" style={{ top: -scrollPosition.top }}>
        {scaleCell}
      </div>
    );
  }
  handleSelectionStart = (col, row) => {
    const startSelectionPosition = {
      x: col,
      y: row,
    };
    this.setState({
      startSelectionPosition,
      mousePosition: startSelectionPosition,
    });
  }
  handleCellMouseEnter = (col, row) => {
    if (this.state.startSelectionPosition != null) {
      this.setState({
        mousePosition: {
          x: col,
          y: row,
        },
      });
    }
  }
  renderSelectedIntervals() {
    const {
      numberOfDays,
      cellHeight,
      scaleUnit,
      selectedIntervals,
      eventSpacing,
      inithour,
      weekdays
    } = this.props;
    const {
      columnDimensions,
      scaleIntervals,
    } = this.state;
    const result = [];
    if (columnDimensions.length === 0 || selectedIntervals.length === 0) {
      return result;
    }
    const offsetTop = getOffset(inithour);
    for (let dayIndex = 0; dayIndex < numberOfDays; dayIndex += 1) {
      const intervals = selectedIntervals.filter(interval => interval.day == weekdays[dayIndex].id);
      if (intervals.length > 0) {
        intervals.sort((i1, i2) => moment(i1.inithour, 'HH:mm').diff(moment(i2.inithour, 'HH:mm'), 'minutes'));

        intervals.forEach((interval, index, array) => {
          const start = moment(interval.inithour, 'HH:mm');
          const end = moment(interval.endhour, 'HH:mm');
          let startY = 0;
          //   if (!start.isBefore(day)) {
          startY = getNumberOfCells(start, scaleUnit, false, offsetTop);
          //   }
          if (startY > scaleIntervals.length) {
            return;
          }

          const beforeIntersectionNumber = array.filter((i, i1) => i1 < index && start.isBefore(moment(i.endhour, 'HH:mm'))).length;
          const afterIntersectionNumber = array.filter((i, i1) => i1 > index && end.isAfter(moment(i.inithour, 'HH:mm'))).length;
          const groupIntersection = (beforeIntersectionNumber + afterIntersectionNumber + 1);

          let endY = getNumberOfCells(end, scaleUnit, true, offsetTop);
          if (endY > scaleIntervals.length) {
            endY = scaleIntervals.length;
          }
          const top = startY * cellHeight;
          const width = (columnDimensions[dayIndex].width - eventSpacing) / groupIntersection;

          // TODO: dividing  by the GroupIntersection doesn't seem to work all that great...
          const left = columnDimensions[dayIndex].left + ((width + Math.floor(eventSpacing / groupIntersection)) * beforeIntersectionNumber);
          const height = (endY - startY) * cellHeight;
          const eventWrapperStyle = {
            top,
            left,
            width,
            height,
          };
          const eventComponent = (
            <div
              className="week-calendar-overlay"
              key={(dayIndex * 20000) + index}
              style={eventWrapperStyle}
              onClick={this.handleEventClick.bind(this, interval)}
            >
              <Event {...interval} />
            </div>
          );
          result.push(eventComponent);
        });
      }
    }
    return result;
  }
  renderOverlay() {
    if (this.state.startSelectionPosition != null) {
      const startPosition = this.state.startSelectionPosition;
      const { mousePosition } = this.state;

      const top = Math.min(startPosition.y, mousePosition.y) * this.props.cellHeight;
      const { left } = this.state.columnDimensions[Math.min(startPosition.x, mousePosition.x)];
      const lastSelectedColumn = this.state.columnDimensions[Math.max(startPosition.x, mousePosition.x)];
      const width = (lastSelectedColumn.left - left) + lastSelectedColumn.width;
      const height = ((Math.max(startPosition.y, mousePosition.y) + 1) * this.props.cellHeight) - top;
      const overlayStyle = {
        top,
        left,
        width,
        height,
      };
      return (
        <div
          className="week-calendar-overlay week-calendar-overlay-status-selection"
          style={overlayStyle}
        />
      );
    }
    return null;
  }
  render() {
    const { scaleHeaderTitle, scaleUnit, cellHeight, weekdays } = this.props;
    const { scaleIntervals, scrollPosition, columnDimensions } = this.state;
    return (
      <div className="week-calendar">
        <div className="week-calendar-scale-header" >
          <span>{scaleHeaderTitle}</span>
        </div>
        <div className="week-calendar-header" style={{ left: -scrollPosition.left }}>
          <CalendarHeader
            columnDimensions={columnDimensions}
            weekdays={weekdays}
          />
        </div>
        {this.renderScale()}
        <div className="week-calendar-content" onScroll={this.handleScroll}>
          <CalendarBody
            cellHeight={cellHeight}
            scaleIntervals={scaleIntervals}
            scaleUnit={scaleUnit}
            onSelectionStart={this.handleSelectionStart}
            onCellMouseEnter={this.handleCellMouseEnter}
          />
          {this.renderSelectedIntervals()}
          {this.renderOverlay()}
        </div>

      </div>
    );
  }
}

WeekCalendar.propTypes = {

};
WeekCalendar.defaultProps = {
  inithour: "00:00",
  endhour: "23:59",
  numberOfDays: 7,
  cellHeight: 25,
  scaleFormat: 'HH:mm',
  scaleUnit: 60,
  scaleHeaderTitle: '',
  eventSpacing: 15,
  selectedIntervals: [],
}

export default WeekCalendar;