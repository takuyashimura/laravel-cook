import { Wrap, WrapItem } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import styled from "styled-components";

type FoodStocks = {
    id: number;
    name: string;
    total_amount: number;
};

const Food = () => {
    const [foodStocks, setFoodStocks] = useState<[FoodStocks] | undefined>(
        undefined
    );

    // 先ほど作成したLaravelのAPIのURL
    const url = "http://localhost:8888/api/home";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);

                setFoodStocks(res.data.food_stocks);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    console.log("foodStocks", foodStocks);
    return (
        <div className="Food">
            <div>
                <a href="/newFood/">新規食材追加</a>
            </div>

            <Wrap>
                {foodStocks &&
                    foodStocks.map((food_stock) => (
                        <WrapItem>
                            <SCord>
                                <p>{food_stock.name}</p>
                                <p>
                                    在庫数
                                    {food_stock.total_amount === null
                                        ? 0
                                        : food_stock.total_amount}
                                    個
                                </p>
                                <p>リンク先未設定</p>
                            </SCord>
                        </WrapItem>
                    ))}
            </Wrap>
        </div>
    );
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Food;
