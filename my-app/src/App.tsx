// import { AssertionError } from "assert";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./Home";
import Register from "./Register";
import Login from "./Login";
import Food from "./components/Food";
import NewFood from "./components/NewFood";
import { Footer } from "./components/footer.css";

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
                </Routes>
            </BrowserRouter>
            <Footer />
        </div>
    );
};

export default App;
