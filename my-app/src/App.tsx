import React, { useEffect, useState } from "react";
// import { AssertionError } from "assert";
import axios from "axios";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Home from "./Home";
import Register from "./Register";
import Login from "./Login";
import { Footer } from "./css/footer.css";
import Food from "./components/Food";

interface article {
    id: number;
    title: string;
    content: string;
}

const App = () => {
    const [value, setValue] = useState([]);

    // 先ほど作成したLaravelのAPIのURL
    const url = "http://localhost:/api/8888/home";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);
                setValue(res.data.post);
                //サイトで拾ってきたコードにはconsoleのコードはなかったので自分で追記
                console.log(res);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);

    return (
        <div className="App">
            <Food />
            {value.map((article: article) => {
                return (
                    <div key={article.id}>
                        <h1>{article.title}</h1>
                        <p>{article.content}</p>
                    </div>
                );
            })}
            <BrowserRouter>
                <Routes>
                    <Route path={`/`} element={<Home />} />
                    <Route path={`/register/`} element={<Register />} />
                    <Route path={`/login/`} element={<Login />} />
                </Routes>
            </BrowserRouter>
            <Footer />
        </div>
    );
};

export default App;
