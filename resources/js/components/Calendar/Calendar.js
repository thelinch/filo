import React, { Component } from 'react';
import PropTypes from 'prop-types';
import dateFns from 'date-fns';
import moment from 'moment';
import { ChevronLeft, ChevronRight } from '@material-ui/icons';

moment.locale('es');
class Calendar extends Component {
    state = {
        dateObject: moment(),
        selectedDate: moment()
      };
    
      month = () => {
        return this.state.dateObject.format("MMMM YYYY");
      }
      renderHeader() {
        return (
          <div className="header row flex-middle">
            <div className="col col-start">
              <div className="icon" onClick={this.prevMonth}>
                <ChevronLeft fontSize="small" />
              </div>
            </div>
            <div className="col col-center">
              <span>{this.month()}</span>
            </div>
            <div className="col col-end" onClick={this.nextMonth}>
              <div className="icon">
                  <ChevronRight fontSize="small" />
              </div>
            </div>
          </div>
        );
      }
    
      renderDays() {
        const weekdays = moment.weekdays();
        const weekdaysname = weekdays.map(day => {
            return <div className="col col-center" key={day}>{day}</div>
        })        
        return <div className="days row">{weekdaysname}</div>;
      }
    
      renderCells() {
        const { dateObject, selectedDate } = this.state;
        const monthStart = moment(dateObject).startOf("month");
        const monthEnd = moment(dateObject).endOf("month");
        const startDate = moment(monthStart).startOf('week');
        const endDate = moment(monthEnd).endOf("week");

        const rows = [];
    
        let days = [];
        let day = startDate;
        let formattedDate = "";
    
        while (day <= endDate) {
          for (let i = 0; i < 7; i++) {
            formattedDate = moment(day).format("D");
            const cloneDay = day;
            days.push(
              <div
                className={`col cell ${
                    !moment(day).isSame(monthStart,'month')
                    ? "disabled"
                    : moment(day).isSame(selectedDate, 'day') ? "selected" : ""
                }`}
                key={day}
                onClick={() => this.onDateClick(moment(cloneDay))}
              >
                <span className="number">{formattedDate}</span>
                <span className="bg">{formattedDate}</span>
              </div>
            );
            day = moment(day).add(1, "day");
          }
          rows.push(
            <div className="row" key={day}>
              {days}
            </div>
          );
          days = [];
        }
        return <div className="body">{rows}</div>;
      }
    
      onDateClick = day => {
        //   console.log(day)
        this.setState({
          selectedDate: day
        });
      };
    
      nextMonth = () => {
        this.setState({
          dateObject: this.state.dateObject.add(1, "month")
        });
      };
    
      prevMonth = () => {
        this.setState({
            dateObject: this.state.dateObject.subtract(1, "month")
        });
      };
    
      render() {
        return (
          <div className="calendar">
            {this.renderHeader()}
            {this.renderDays()}
            {this.renderCells()}
          </div>
        );
      }
}

Calendar.propTypes = {

};

export default Calendar;