import React, { useContext } from "react"
import { SearchContext } from "../../Contexts/SearchContext";
import CategoriesList from "../Down/CategoriesList";
import { Typography, Divider, Grid } from "@material-ui/core";
import FavoriteList from "../Down/Favorites/FavoriteList"

const Search = () => {
    const { categories, favorites } = useContext(SearchContext)
    const handleClickCategory = (categoryId) => {
        console.log(categoryId)
    }


    return (
        <div className="search container">
            <div className="categories">
                <Typography className="title">
                    Explora nuestras categorias
                </Typography>
                <Divider />

                <CategoriesList categories={categories} handleClick={handleClickCategory} />

            </div>
            <div className="favorites">
                <Typography className="title">
                    Populares
                </Typography>
                <Divider />
                <Grid container spacing={3}>
                    <FavoriteList favorites={favorites} />
                </Grid>

            </div>
        </div>
    )

}
export default Search;