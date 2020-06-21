import React from "react";
import CategoriesList from "../../components/Down/CategoriesList";
import { CategoryService } from "../../Services/CategoryService";
import PartnerList from "../../components/Down/PartnerList";
import { navigate } from "@reach/router"
import { PartnerService } from "../../Services/ParterService";
import { getObjectFindId } from "../../Util/Util"
class InitPage extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            categories: [],
            partners: []
        }
    }
    async componentDidMount() {
        /*    setTimeout(() => {
               let { partners } = this.state
               partners.push({ id: "dwd", name: "El Carbon", category: { name: "Polleria" }, phone: "9745445", description: "Somos una polleria al alcanze de todos wdwdwdw   dwdwdwd122323   wdwd", direction: "Jiron San Alejandro", url: "/img/polleria.jpg" });
               partners.push({ id: "dwd1", name: "El Marañom", category: { name: "Restaurante" }, phone: "9745445", description: "Somos una polleria al alcanze de todos wdwdwd wdwdwdddd", direction: "Jiron San Alejandro", url: "/img/polleria.jpg" });
               partners.push({ id: "dwd2", name: "El Cabaña", category: { name: "Muebleria" }, phone: "9745445", description: "Somos una polleria al alcanze de todos wdwdwdwd  wdwdwd d21212wdwdwd ", direction: "Jiron San Alejandro", url: "/img/polleria.jpg" });
               partners.push({ id: "dwd3", name: "El Carboncito", category: { name: "Ferreteria" }, phone: "9745445", description: "Somos una polleria al alcanze de todos wdwdwdwdwddwd  wdw1212ewd ", direction: "Jiron San Alejandro", url: "/img/polleria.jpg" });
               this.setState({ partners })
           }, 2000)
    */
        let categories = (await CategoryService.getAll()).data
        let partners = (await PartnerService.getAll()).data.data
        this.setState({ partners, categories })


        this.setState({ categories })
    }
    handleClickCategory = (category) => {
        console.log(category);

    }
    handleClickPartner = (partnerId) => () => {
        console.log(partnerId)
        const { partners } = this.state
        const partner = getObjectFindId(partners, partnerId);

        navigate(`/partner/${partnerId}`, { state: { partner: partner } })
    }
    render() {
        const { categories, partners } = this.state
        return (<React.Fragment>
            <CategoriesList categories={categories} handleClick={this.handleClickCategory} />
            <PartnerList partners={partners} handleClick={this.handleClickPartner} />
        </React.Fragment>)
    }
}

export default InitPage;