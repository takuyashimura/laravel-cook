import axios from "axios";
import { useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";

const FoodToMenus = () => {
    const location = useLocation();
    const { data } = location.state;
    const length = data[1].length;
    console.log("data", data);
    const navigate = useNavigate();

    const onClickFpodData = (d: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu: d })
            .then((response) => {
                console.log("post", response.data);
                navigate("/MenuCook/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    return (
        <>
            <div>
                <h1>{data[0]}</h1>
                {!!length ? (
                    data[1].map((d: any) => (
                        <div onClick={() => onClickFpodData(d)}>
                            <p>{d.name}</p>
                        </div>
                    ))
                ) : (
                    <p>使用するメニューがありません</p>
                )}
                <div></div>
            </div>
        </>
    );
};

export default FoodToMenus;
