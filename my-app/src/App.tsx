// import { AssertionError } from "assert";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./Home";
import Register from "./Register";
import Login from "./Login";

import Food from "./components/Food";
import { Footer } from "./components/footer.css";
import Menu from "./components/Menu";
import NewMenu from "./components/NewMenu";
import BuyList from "./components/BuyList";
import CookingList from "./components/cookingList";
import EditBuyList from "./components/editBuyList";
import FoodToMenus from "./components/FoodToMenus";
import MenuCook from "./components/MenuCook";
import EditMenu from "./components/EditMenu";
import { Box, ChakraProvider } from "@chakra-ui/react";

import GlobalNav from "./components/GlobalNav";
import Top from "./components/Top";
import About from "./components/About";

import theme from "./theme/theme";
import ReactDOM from "react-dom";

const App = () => {
    return (
        <div className="App">
            <ChakraProvider theme={theme}>
                <Box mb={"120px"}>
                    <BrowserRouter>
                        <GlobalNav />

                        <Routes>
                            <Route path={"/"} element={<Top />} />
                            <Route path={"/about"} element={<About />} />
                            <Route path={`/register/`} element={<Register />} />
                            <Route path={`/login/`} element={<Login />} />
                            <Route path={`/Food/`} element={<Food />} />
                            <Route path={`/menu/`} element={<Menu />} />
                            <Route path={`/newmenu/`} element={<NewMenu />} />
                            <Route path={`/buyList/`} element={<BuyList />} />
                            <Route
                                path={`/cookingList/`}
                                element={<CookingList />}
                            />
                            <Route
                                path={`/editBuyList/`}
                                element={<EditBuyList />}
                            />
                            <Route
                                path={`/FoodToMenus/`}
                                element={<FoodToMenus />}
                            />
                            <Route path={`/MenuCook/`} element={<MenuCook />} />
                            <Route path={`/EditMenu/`} element={<EditMenu />} />
                        </Routes>
                    </BrowserRouter>{" "}
                </Box>
                <Box>
                    <Footer />
                </Box>
            </ChakraProvider>
        </div>
    );
};
if (document.getElementById("nav")) {
    ReactDOM.render(<App />, document.getElementById("nav"));
}

export default App;
