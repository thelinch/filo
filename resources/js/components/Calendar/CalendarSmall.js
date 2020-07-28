import React, { Component } from 'react';
import PropTypes from 'prop-types';
import moment from 'moment';
moment.locale('es');
class CalendarSmall extends Component {
    weekdayshort = moment.weekdaysShort();
    state = {
        dateObject: moment(),
        allmonths: moment.months(),
        showMonthTable: false,
        showYearTable: false,
        showDateTable: true,
        selectedDay: null
    }
    daysInMonth = () => {
        return this.state.dateObject.daysInMonth();
    }
    firstDayOfMonth = () => {
        let dateObject = this.state.dateObject;
        let firstDay = moment(dateObject)
                        .startOf("month")
                        .format("d");
        return firstDay;
    }
    showMont = () => {
        this.setState({
            showMonthTable: !this.state.showMonthTable,
            showDateTable: !this.state.showDateTable
        })
    }
    month = () => {
        let month = this.state.dateObject.format("MMMM");
        return month.charAt(0).toUpperCase() + month.slice(1);
    }

    currentDay = () =>{
        return this.state.dateObject.format("D")
    }
    setMonth = month => {
        let monthNo = this.state.allmonths.indexOf(month);
        let dateObject = Object.assign({}, this.state.dateObject);
        dateObject = moment(dateObject).set("month", monthNo);
        this.setState({
            dateObject: dateObject,
            showMonthTable: !this.state.showMonthTable,
            showDateTable: !this.showDateTable
        })
    }
    MonthList = props => {
        let months = [];
        props.data.map(data => {
            months.push(
                <td 
                    key={data}
                    className="calendar-month"
                    onClick={() => {
                        this.setMonth(data)
                    }}
                >
                    <span>{data.charAt(0).toUpperCase() + data.slice(1)}</span>
                </td>
            )
        })

        let rows = [];
        let cells = [];
        months.forEach((row, i) => {
            if(i % 3 !== 0 || i == 0){
                cells.push(row);
            } else {
                rows.push(cells);
                cells = [];
                cells.push(row);
            }
        })
        rows.push(cells);

        let monthlist = rows.map((d, i) => {
            return <tr key={i}>{d}</tr>
        })
        return (
            <table className="calendar-month">
                <thead>
                    <tr>
                        <th colSpan="4">Seleccionar un mes</th>
                    </tr>
                </thead>
                <tbody>{monthlist}</tbody>
            </table>
        );
    }
    getDates = (startDate, stopDate) => {
        var dateArray = [];
        var currentDate = moment(startDate);
        var stopDate = moment(stopDate);
        while(currentDate <= stopDate) {
            dateArray.push(moment(currentDate).format("YYYY"));
            currentDate = moment(currentDate).add(1, "year");
        }
        return dateArray;
    }
    setYear = year => {
        let dateObject = Object.assign({}, this.state.dateObject);
        dateObject = moment(dateObject).set("year", year);
        this.setState({
            dateObject: dateObject,
            showMonthTable: !this.state.showMonthTable,
            showYearTable: !this.state.showYearTable
        })
    }
    year = () => {
        return this.state.dateObject.format("Y");
    }
    YearTable = props => {
        let months = [];
        let nextten = moment()
            .set("year", props)
            .add("year", 12)
            .format("Y");

        let twelveyears = this.getDates(props, nextten);

        twelveyears.map(data => {
            months.push(
                <td
                    key={data}
                    className="calendar-month"
                    onClick={() => this.setYear(data)}
                >
                    <span>{data}</span>
                </td>
            )
        })

        let rows = [];
        let cells = [];

        months.forEach((row, i) => {
            if(i % 3 !== 0 || i == 0) {
                cells.push(row);
            } else {
                rows.push(cells);
                cells = [];
                cells.push(row);
            }
        })
        rows.push(cells);

        let yearlist = rows.map((d, i) => {
            return <tr key={i}>{d}</tr>
        })
        return (
            <table className="calendar-month">
                <thead>
                    <tr>
                        <th colSpan="4">Seleccionar un año</th>
                    </tr>
                </thead>
                <tbody>{yearlist}</tbody>
            </table>
        )
    }
    showYearTable = () => {
        this.setState({
            showYearTable: !this.state.showYearTable,
            showDateTable: !this.state.showDateTable
        })
    }
    onPrev = () => {
        let curr="";
        if (this.state.showYearTable == true) {
            curr = "year";
        } else {
            curr = "month"
        }
        this.setState({
            dateObject: this.state.dateObject.subtract(1, curr)
        })
    }
    onNext = () => {
        let curr = "";
        if (this.state.showYearTable == true){
            curr = "year";
        } else {
            curr = "month";
        }
        this.setState({
            dateObject: this.state.dateObject.add(1, curr)
        })
    }
    onDayClick = (d) => {
        this.setState({
            selectedDay: d
        },
        () => {
            console.log("SELECTED DAY: ", this.state.selectedDay);
        }
        )
    }
    render() {
        let weekdayshortname = this.weekdayshort.map(day => {
            return <th key={day}>{day.charAt(0).toUpperCase() + day.slice(1).replace('.','')}</th>;
        });
        
        let blanks = [];
        for(let i=0; i < this.firstDayOfMonth(); i++){
            blanks.push(<th key={`empty-${i}`} className="calendar-day empty">{""}</th>);
        }

        let daysInMonth = [];
        for(let d=1; d <= this.daysInMonth(); d++) {
            let currentDay = d == this.currentDay() ? "today" : "";
            daysInMonth.push(
                <td key={d} className={`calendar-day ${currentDay}`}>
                    <span onClick={() => this.onDayClick(d)}>{d}</span>
                </td>
            )
        }

        var totalSlot = [...blanks, ...daysInMonth];
        let rows = [];
        let cells = [];
        totalSlot.forEach((row, i) => {
            if (i % 7 !== 0){
                cells.push(row);
            } else {
                rows.push(cells)
                cells = [];
                cells.push(row);
            }
            if(i === totalSlot.length -1){
                rows.push(cells);
            }

        })
        let daysinmonth = rows.map((d, i) => {
            return <tr key={i}>{d}</tr>
        })
        return (
            <div className="tail-datetime-calendar">
                <div className="calendar-navi">
                    <span onClick={this.onPrev} className="calendar-button button-prev" />
                    <span className="calendar-label" onClick={this.showMont}>
                        {this.month()}
                    </span>
                    <span className="calendar-label" onClick={this.showYearTable}>
                        {this.year()}
                    </span>
                    <span onClick={this.onNext} className="calendar-button button-next" />
                </div>
                <div className="calendar-date">
                    {this.state.showYearTable && <this.YearTable props={this.year()} />}
                    {this.state.showMonthTable && <this.MonthList data={moment.months()} />}
                </div>
                {this.state.showDateTable && 
                    <div className="calendar-date">
                        <table className="calendar-day">
                            <thead>
                                <tr>{weekdayshortname}</tr>
                            </thead>
                            <tbody>{daysinmonth}</tbody>
                        </table>
                    </div>
                }
                
            </div>
        );
    }
}

CalendarSmall.propTypes = {

};

export default CalendarSmall;
