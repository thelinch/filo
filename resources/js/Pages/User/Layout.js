import React from "react"
import { Router } from "@reach/router"
import InitPage from "./InitPage"
import PartnerPage from "./PartnerPage"
import { SearchProvider } from "../../Contexts/SearchContext";
import Header from "./Header";

class Layout extends React.Component {

    constructor(props) {
        super(props)
    }

    render() {
        return (
            <React.Fragment>
                <SearchProvider>
                    <nav>
                        <Header />
                    </nav>
                    <div className="main">
                        <Router>

                            <InitPage path="/" />
                            <PartnerPage path="/partner/:partnerId" />
                        </Router>
                    </div>
                </SearchProvider>
            </React.Fragment>
        )

    }
}


export default Layout;


