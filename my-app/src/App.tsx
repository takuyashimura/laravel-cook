// import { AssertionError } from "assert";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./Home";
import Register from "./Register";
import Login from "./Login";
import Food from "./components/Food";
import { Footer } from "./components/footer.css";
import Menu from "./components/Menu";
import BuyList from "./components/BuyList";
import CookingList from "./components/cookingList";

import { Box, ChakraProvider } from "@chakra-ui/react";

import theme from "./theme/theme";
import ReactDOM from "react-dom";

const App = () => {
    return (
        <div className="App">
            <ChakraProvider theme={theme}>
                <Box mb={"55px"}>
                    <BrowserRouter>
                        {" "}
                        <Routes>
                            <Route path={`/register/`} element={<Register />} />
                            <Route path={`/login/`} element={<Login />} />
                            <Route path={`/Food/`} element={<Food />} />

                            <Route path={`/`} element={<Food />} />

                            <Route path={`/food/`} element={<Food />} />
                            <Route path={`/menu/`} element={<Menu />} />
                            <Route path={`/buyList/`} element={<BuyList />} />
                            <Route
                                path={`/cookingList/`}
                                element={<CookingList />}
                            />
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

export default App;
