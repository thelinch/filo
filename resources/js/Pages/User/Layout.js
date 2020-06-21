import React from "react"
import { Router } from "@reach/router"
import InitPage from "./InitPage"
import Header from "../../components/User/Header/Header"
import PartnerPage from "./PartnerPage"


class Layout extends React.Component {

    constructor(props) {
        super(props)
    }

    render() {
        return (
            <React.Fragment>
                <div className="main">
                    <Router>

                        <InitPage path="/" />
                        <PartnerPage path="/partner/:partnerId" />
                    </Router>
                </div>
            </React.Fragment>
        )

    }
}


export default Layout;


