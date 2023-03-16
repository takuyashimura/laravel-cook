import axios from "axios";
import { useEffect, useState } from "react";

type FoodData = {
    name: string;
    amount: number;
};

const NewFood = () => {
    const [FoodData, setFoodData] = useState<FoodData>({
        name: "食材名",
        amount: 0,
    });

    // const OnClickCountUp = () => {
    //     setFoodData({
    //         ...FoodData,
    //         amount: FoodData.amount + 1,
    //     });
    // };
    // const OnClickCountDown = () => {
    //     setFoodData({
    //         ...FoodData,
    //         amount: FoodData.amount - 1,
    //     });
    // };

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

        // useEffect(() => {
        //     fetch("/api/add")
        //         .then((response) => response.json())
        //         .then((data) => setData(data))
        //         .catch((error) => console.error(error));
        // }, []);
        return false;
    };

    const addButtom = FoodData.name;

    // const [data, setData] = useState<{ message?: string }>();

    // useEffect(() => {
    //     // APIからデータを取得し、ステートに保存する
    //     fetch("/api/add")
    //         .then((response) => response.json())
    //         .then((data) => setData(data))
    //         .catch((error) => console.error(error));
    //     console.log(data);
    // }, []);

    // const content = data ? <div>{data.message}</div> : <div>Loading...</div>;
    return (
        <>
            <form onSubmit={handleSubmit}>
                <div>
                    <input
                        type="search"
                        name="name"
                        placeholder={FoodData.name}
                        onChange={OnChangeName}
                    />
                    {/* <p>{FoodData.amount}</p>
                    <button type="button" onClick={OnClickCountUp}>
                        +
                    </button>
                    <button type="button" onClick={OnClickCountDown}>
                        -
                    </button> */}
                </div>
                <div>
                    {addButtom === "食材名" || addButtom === "" ? (
                        <p>食材名を記入してください</p>
                    ) : (
                        <button type="submit">新規食材追加</button>
                    )}
                </div>
            </form>
        </>
    );
};

export default NewFood;
function pressEnter(e: any) {
    throw new Error("Function not implemented.");
}
