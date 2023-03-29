import { Button, Wrap, WrapItem } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
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

    const handlePost = (food_stock: any) => {
        axios
            .post("http://localhost:8888/api/foodToMenu", { food_stock })
            .then((response) => {
                console.log("post", response.data);
                navigate("/FoodToMenus/", { state: { data: response.data } });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePost1 = (food_stock: any) => {
        axios
            .post("http://localhost:8888/api/food_delete", { food_stock })
            .then((response) => {
                console.log("response", response.data);
                window.location.reload();
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const navigate = useNavigate();

    return (
        <div className="Food">
            <div>
                <a href="/newFood/">新規食材追加</a>
            </div>

            <Wrap>
                {foodStocks &&
                    foodStocks.map((food_stock) => (
                        <WrapItem key={food_stock.id}>
                            <SCord>
                                <p>{food_stock.name}</p>
                                <p>
                                    在庫数
                                    {food_stock.total_amount === null
                                        ? 0
                                        : food_stock.total_amount}
                                    個
                                </p>
                                <p onClick={() => handlePost(food_stock)}>
                                    選択
                                </p>
                                <p onClick={() => handlePost1(food_stock)}>
                                    削除
                                </p>
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
