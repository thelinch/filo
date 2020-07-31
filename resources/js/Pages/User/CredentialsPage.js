import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Tab from '@material-ui/core/Tab';
import TabContext from '@material-ui/lab/TabContext';
import TabList from '@material-ui/lab/TabList';
import TabPanel from '@material-ui/lab/TabPanel';
import InitSessionForm from "../../components/Form/InitSessionForm"
import RegisterForm from "../../components/Form/RegisterForm"
import { Paper } from '@material-ui/core';

export default function LabTabs() {
    const [value, setValue] = React.useState('1');

    const handleChange = (event, newValue) => {
        setValue(newValue);
    };

    return (
        <Paper style={{ width: "50%", margin: "0 auto" }}>
            <TabContext value={value}>
                <TabList onChange={handleChange} aria-label="simple tabs example">
                    <Tab label="Iniciar Session" value="1" />
                    <Tab label="Registrate" value="2" />
                </TabList>
                <TabPanel value="1">
                    <InitSessionForm />
                </TabPanel>
                <TabPanel value="2">

                    <RegisterForm />
                </TabPanel>
            </TabContext>

        </Paper>
    );
}