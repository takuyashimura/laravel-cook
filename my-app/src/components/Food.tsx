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
                //サイトで拾ってきたコードにはconsoleのコードはなかったので自分で追記
                console.log(res);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    return;
    <div className="Food">
        <Wrap>
            {foodStocks ? (
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
                        </SCord>
                    </WrapItem>
                ))
            ) : (
                <div>Loading...</div>
            )}
        </Wrap>
    </div>;
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Food;
