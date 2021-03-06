const React = require("react");
const ReactDOM = require("react-dom");

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import { Router, Link } from "@reach/router";
import Layout from "./Pages/User/Layout";
import LayoutAdmin from "./Pages/Admin/LayoutAdmin";
import moment from "moment"
import { Provider } from 'react-redux';
import store from './store';

import { MuiPickersUtilsProvider } from '@material-ui/pickers';
import DateFnsUtils from '@date-io/date-fns';

class App extends React.Component {
    render() {

        return (
            <Provider store={store}>
                <MuiPickersUtilsProvider utils={DateFnsUtils}>
                    <Router>
                        <Layout path="/*" />
                        <LayoutAdmin path="/admin/*" />
                    </Router>
                </MuiPickersUtilsProvider>
            </Provider>
        )
    }
}
ReactDOM.render(<App />, document.getElementById("app"));
