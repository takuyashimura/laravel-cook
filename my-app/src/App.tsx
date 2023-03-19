// import { AssertionError } from "assert";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./Home";
import Register from "./Register";
import Login from "./Login";
import Food from "./components/Food";
import NewFood from "./components/NewFood";
import { Footer } from "./components/footer.css";
import Menu from "./components/Menu";
import NewMenu from "./components/NewMenu";
import BuyList from "./components/BuyList";

const App = () => {
    return (
        <div className="App">
            <BrowserRouter>
                <Routes>
                    <Route path={`/`} element={<Home />} />
                    <Route path={`/register/`} element={<Register />} />
                    <Route path={`/login/`} element={<Login />} />
                    <Route path={`/Food/`} element={<Food />} />
                    <Route path={`/newFood/`} element={<NewFood />} />
                    <Route path={`/menu/`} element={<Menu />} />
                    <Route path={`/newmenu/`} element={<NewMenu />} />
                    <Route path={`/buyList/`} element={<BuyList />} />
                </Routes>
            </BrowserRouter>
            <Footer />
        </div>
    );
};

export default App;
