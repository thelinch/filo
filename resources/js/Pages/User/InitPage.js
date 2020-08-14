import React from "react";
import CategoriesList from "../../components/Down/CategoriesList";
import { CategoryService } from "../../Services/CategoryService";
import PartnerList from "../../components/Down/PartnerList";
import { navigate, Link } from "@reach/router"
import { PartnerService } from "../../Services/ParterService";
import { getObjectFindId } from "../../Util/Util"
import { SearchContext } from "../../Contexts/SearchContext";
import Chip from "@material-ui/core/Chip";
import NightsStayIcon from '@material-ui/icons/NightsStay';
import PartnerDomain from "../../Domain/PartnerDomain";
import Snackbar from '@material-ui/core/Snackbar';
import TablePagination from "@material-ui/core/TablePagination";

class InitPage extends React.Component {
    static contextType = SearchContext

    constructor(props) {
        super(props);
        this.state = {
            categories: [],
            partners: [],
            initPartnerValue: [],
            openSnackBar: false,
            isLoadingPartners: true,
            page: 0,
            itemsPerPage: 10
        }

    }
    handleChangePage = (event, newPage) => {
        this.setState({ page: newPage })
    }
    handleChangeItemsPerPage = (event) => {
        this.setState({ itemsPerPage: +event.target.value, page: 0 })
    }
    handleOpenSnackBar = () => {
        this.setState({ openSnackBar: true })
    }
    handleCloseSnackBar = () => {
        this.setState({ openSnackBar: false })

    }
    async componentDidMount() {
        this.context.setFavorites([]);
        this.context.setCategories([]);
        const [categoriesPromise, partnersPromise] = (await Promise.all([CategoryService.getAll(), PartnerService.getAll()]))
        let categories = categoriesPromise.data
        let partners = partnersPromise.data.data
        partners = partners.map((partner) =>
            Object.freeze(new PartnerDomain(partner.id, partner.description, partner.name, partner.dishes, partner.category, partner.address, partner.phone, partner.workdays, partner.city, partner.photo, partner.amountdelivery)))
        this.setState({ partners, categories, isLoadingPartners: false, initPartnerValue: partners })
        this.context.setCategories(categories);
        let partnerMap = partners.map((partner) => (
            <div className="favorites-partner" key={partner.id} onClick={this.handleClickPartner(partner)}>
                <div className="photo">
                    <img src={partner.photo} />
                </div>
                <div className="content">
                    <h6 className="title">{partner.name}</h6>
                    <p className="direction">{partner.address}</p>
                    {
                        !partner.isAvailableForAttend && <strong>{partner.textAlternativeForAttend()}</strong>
                    }
                </div>
                <div className="labels">
                    {
                        !partner.isAvailableForAttend && <NightsStayIcon />
                    }
                    <Chip label={partner.category.name} className="items category" />
                </div>
            </div>
        ));
        this.context.setFavorites(partnerMap);

    }
    handleClickCategory = (categoryId) => {
        const { initPartnerValue } = this.state
        if (categoryId == -1) {
            this.setState({ partners: initPartnerValue, page: 0 })
            return;
        }
        let partnersFilter = initPartnerValue.filter((partner) => partner.category.id == categoryId)
        this.setState({ partners: partnersFilter, page: 0 })

    }
    handleClickPartner = (partner) => () => {
        if (!partner.isAvailableForAttend) {
            this.handleOpenSnackBar()
            return;
        }
        navigate(`/partner/${partner.id}`, { state: { partner: Object.seal(partner) } })
    }
    render() {
        const { categories, partners, openSnackBar, itemsPerPage, page, isLoadingPartners } = this.state
        const partnerPaginate = partners.slice(page * itemsPerPage, page * itemsPerPage + itemsPerPage);
        return (<React.Fragment>
            <div className="container categories">
                <CategoriesList categories={categories} handleClick={this.handleClickCategory} />
            </div>
            <PartnerList partners={partnerPaginate} isLoading={isLoadingPartners} handleClick={this.handleClickPartner} />
            <TablePagination
                rowsPerPageOptions={[10, 20, 100]}
                component="div"
                count={partners.length}
                rowsPerPage={itemsPerPage}
                page={page}
                onChangePage={this.handleChangePage}
                onChangeRowsPerPage={this.handleChangeItemsPerPage}
            />
            <Snackbar
                anchorOrigin={{ vertical: "bottom", horizontal: "center" }}
                open={openSnackBar}
                onClose={this.handleCloseSnackBar}
                message="La empresa actualmente no recibe pedidos"
                autoHideDuration={3000}
                key="dedffefe-22w"
            />
        </React.Fragment>)
    }
}

export default InitPage;