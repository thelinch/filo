import React from "react";
import CategoriesList from "../../components/Down/CategoriesList";
import { CategoryService } from "../../Services/CategoryService";
import PartnerList from "../../components/Down/PartnerList";
import { navigate } from "@reach/router"
import { PartnerService } from "../../Services/ParterService";
import { getObjectFindId } from "../../Util/Util"
import { SearchContext } from "../../Contexts/SearchContext";
class InitPage extends React.Component {
    static contextType = SearchContext

    constructor(props) {
        super(props);
        this.state = {
            categories: [],
            partners: []
        }
    }
    async componentDidMount() {
        const [categoriesPromise, partnersPromise] = (await Promise.all([CategoryService.getAll(), PartnerService.getAll()]))
        let categories = categoriesPromise.data
        let partners = partnersPromise.data.data
        this.setState({ partners, categories })
        this.context.setCategories(categories);
        let partnerMap = partners.map((partner) => (
            <p>{partner.name}</p>
        ));
        this.context.setFavorites(partnerMap);

    }
    handleClickCategory = (category) => {
        console.log(category);

    }
    handleClickPartner = (partnerId) => () => {
        console.log(partnerId)
        const { partners } = this.state
        const partner = getObjectFindId(partners, partnerId);
        if (partner.isAvailableForAttend) {
            navigate(`/partner/${partnerId}`, { state: { partner: partner } })
        }

    }
    render() {
        const { categories, partners } = this.state
        return (<React.Fragment>
            <div className="container categories">
                <CategoriesList categories={categories} handleClick={this.handleClickCategory} />
            </div>

            <PartnerList partners={partners} handleClick={this.handleClickPartner} />
        </React.Fragment>)
    }
}

export default InitPage;