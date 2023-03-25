import { useState } from "react";
import { useLocation } from "react-router-dom";

const FoodToMenus = () => {
    const location = useLocation();
    const { data } = location.state;
    const length = data[1].length;
    console.log("data[1].length", data[1].length);
    return (
        <>
            <div>
                <h1>{data[0]}</h1>
                {!!length ? (
                    data[1].map((d: any) => <p>{d.name}</p>)
                ) : (
                    <p>使用するメニューがありません</p>
                )}
                <div></div>
            </div>
        </>
    );
};

export default FoodToMenus;
