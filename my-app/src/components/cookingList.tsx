import { Button } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";

type cookingList = {
    id: number;
    name: string;
};

type StocksData = {
    id: number;
    food_name: string;
    amount: number;
};

const CookingList = () => {
    const [cookingList, setCookingList] = useState<[cookingList] | undefined>(
        undefined
    );
    const [nonStocksData, setnonStocksData] = useState<
        [StocksData] | undefined
    >(undefined);
    const [onStocksData, setOonStocksData] = useState<[StocksData] | undefined>(
        undefined
    );
    const [toBuyList, settoBuyList] = useState([nonStocksData, onStocksData]);
    const [useList, setUseList] = useState<[StocksData] | undefined>(undefined);

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(
                    "http://localhost:8888/api/cooking_list"
                );
                console.log(
                    "res.data.cooking_list_food_name_amount",
                    res.data.cooking_list_food_name_amount
                );
                console.log("res.data", res.data);
                setCookingList(res.data.cooking_list);
                setnonStocksData(res.data.non_stocks_data);
                setOonStocksData(res.data.on_stocks_data);
                setUseList(res.data.cooking_list_food_name_amount);
                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    // console.log("nonStocksData", nonStocksData);

    //post↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

    useEffect(() => {
        settoBuyList([nonStocksData, onStocksData]);
    }, [nonStocksData, onStocksData]);

    const HandleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post(
                "http://localhost:8888/api/addBuyListByCoookingList",
                toBuyList
            )
            .then((response) => {
                console.log("帰ってきたお", response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const HandleSubmit1 = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/cooking", useList)
            .then((response) => {
                console.log("帰ってきたお", response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const length = onStocksData?.length || nonStocksData?.length;

    console.log("length", !!length);

    return (
        <>
            <form onSubmit={HandleSubmit}>
                {nonStocksData && onStocksData && !!length ? (
                    <>
                        <div>
                            <p>不足食材名と分量</p>
                        </div>
                        {nonStocksData.map((d) => (
                            <div key={d.id}>
                                <p>{d.food_name}</p>
                                <p>{d.amount}</p>
                            </div>
                        ))}
                        {onStocksData.map((d) => (
                            <div key={d.id}>
                                <p>{d.food_name}</p>
                                <p>{d.amount}</p>
                            </div>
                        ))}
                        <Button type="submit">
                            不足分を買い物リストに追加する
                        </Button>
                    </>
                ) : (
                    <p>不足している食材はありません</p>
                )}
            </form>

            {cookingList &&
                cookingList.map((c) => (
                    <div key={c.id}>
                        <p>{c.name}</p>
                    </div>
                ))}
            <form onSubmit={HandleSubmit1}>
                <p>使用する食材</p>
                {useList &&
                    useList.map((u) => (
                        <div key={u.id}>
                            <p>{u.food_name}</p>
                            <p>{u.amount}</p>
                        </div>
                    ))}
                <Button type="submit">調理をする</Button>{" "}
                <p>食材数の確認をする</p>
            </form>
        </>
    );
};

export default CookingList;