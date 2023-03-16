import { Button, ChakraProvider, useToast } from "@chakra-ui/react";
import axios from "axios";
import { useState } from "react";
import Food from "./Food";

type FoodData = string;

const NewFood = () => {
    const [foodData, setFoodData] = useState<FoodData>("食品名");

    const OnChangeName = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFoodData(e.target.value);
    };

    const HandleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        axios
            .post("http://localhost:8888/api/add", foodData)
            .then((response) => {
                setFoodData(response.data);
                console.log(foodData);
                HandleAddFood();
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const toast = useToast();

    const HandleAddFood = () => {
        if (foodData === "この食材はすでに登録されています。") {
            toast({
                title: "既に登録されています",
                description: "食材ページを確認してください",
                status: "error",
                duration: 9000,
                isClosable: true,
            });
        }
    };

    return (
        <>
            <div>
                <ChakraProvider>
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
            </div>
        </>
    );
};

export default NewFood;
