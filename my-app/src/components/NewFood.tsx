import axios from "axios";
import { useState } from "react";

type FoodData = {
    name: string;
    amount: number;
};

const NewFood = () => {
    const [FoodData, setFoodData] = useState<FoodData>({
        name: "新規食材名を記入してください",
        amount: 0,
    });

    const OnClickCountUp = () => {
        setFoodData({
            ...FoodData,
            amount: FoodData.amount + 1,
        });
    };
    const OnClickCountDown = () => {
        setFoodData({
            ...FoodData,
            amount: FoodData.amount - 1,
        });
    };

    const OnChangeName = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFoodData({
            ...FoodData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add", FoodData)
            .then((response) => {
                console.log(response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    };
    return (
        <>
            <div>
                <input
                    type="text"
                    name="name"
                    placeholder={FoodData.name}
                    onChange={OnChangeName}
                />
                <p>{FoodData.amount}</p>
                <button onClick={OnClickCountUp}>+</button>
                <button onClick={OnClickCountDown}>-</button>
            </div>
            <form onSubmit={handleSubmit}>
                <button type="submit">新規食材追加</button>
            </form>
        </>
    );
};

export default NewFood;
