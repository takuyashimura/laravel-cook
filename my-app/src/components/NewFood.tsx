import { Button, ChakraProvider, useToast } from "@chakra-ui/react";
import axios from "axios";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

type FoodData = string;

const NewFood = () => {
    const [foodData, setFoodData] = useState<FoodData>("食品名");

    const OnChangeName = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFoodData(e.target.value);
    };

    const navigation = useNavigate();

    const HandleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add", foodData)
            .then((response) => {
                console.log(response.data);
                if (response.data === "登録完了") {
                    navigation("/Food/");
                    //画面遷移するとトーストが表示されない
                    toast({
                        title: "正常に登録されました",
                        description: "食材ページを確認してください",
                        status: "success",
                        duration: 9000,
                        isClosable: true,
                    });
                } else {
                    toast({
                        title: "既に登録されています",
                        description: "食材ページを確認してください",
                        status: "error",
                        duration: 9000,
                        isClosable: true,
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const toast = useToast();

    return (
        <>
            <ChakraProvider>
                {/* レイアウトを整えるのにstackを使う 
                    時間に余裕があればmodalを用いたい。*/}
                <form onSubmit={HandleSubmit}>
                    <div>
                        <input
                            type="text"
                            name="name"
                            placeholder={foodData || "食品名"}
                            onChange={OnChangeName}
                        />
                    </div>

                    {foodData === "食品名" ||
                    foodData === "" ||
                    foodData.length === 0 ? (
                        <p>食材名を記入してください</p>
                    ) : (
                        <Button type="submit" isDisabled={!foodData}>
                            新規食材追加
                        </Button>
                    )}
                </form>
            </ChakraProvider>
        </>
    );
};

export default NewFood;
