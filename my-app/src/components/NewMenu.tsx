import {
    Button,
    ChakraProvider,
    NumberDecrementStepper,
    NumberIncrementStepper,
    NumberInput,
    NumberInputField,
    NumberInputStepper,
    useToast,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

type MenuName = string;
type Amount = number;

type Food = {
    id: number;
    name: string;
};

const NewMenu = () => {
    //↓GET受信関係 ----------------------------------------------------------------------------------------------
    const [food, setFood] = useState<[Food] | undefined>(undefined);

    const url = "http://localhost:8888/api/add_menu";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);

                setFood(res.data.food);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);

    //↑GET受信関係 ----------------------------------------------------------------------------------------------

    //↓POST送信関係 ----------------------------------------------------------------------------------------------
    const [menuName, setMenuName] = useState<MenuName>();

    const [amount, setAmount] = useState<Amount>(0);

    const [menuData, setMenuData] = useState({
        name: menuName,
        amount: amount,
    });

    const OnChangeName = (e: React.ChangeEvent<HTMLInputElement>) => {
        setMenuName(e.target.value);
    };

    useEffect(() => {
        setMenuData({ ...menuData, name: menuName });
    }, [menuName]);

    useEffect(() => {
        setMenuData({ ...menuData, amount: amount });
    }, [amount]);

    const handleAmountChange = (id: number, value: string) => {
        setFoods((prevFoods) =>
            prevFoods.map((food) => {
                if (food.id === id) {
                    return { ...food, amount: parseFloat(value) };
                }
                return food;
            })
        );
    };
    // const HandleAddFood = (foodDatas: string) => {
    //     if (foodDatas === "この食材はすでに登録されています。") {
    //         toast({
    //             title: "既に登録されています",
    //             description: "食材ページを確認してください",
    //             status: "error",
    //             duration: 9000,
    //             isClosable: true,
    //         });
    //     }
    // };
    // const HandleAddFood2 = () => {
    //     if (menuName === "この食材はすでに登録されています。") {
    //         toast({
    //             title: "既に登録されています",
    //             description: "食材ページを確認してください",
    //             status: "error",
    //             duration: 9000,
    //             isClosable: true,
    //         });
    //     }
    // };

    //メニューが登録できた際の画面推移に使用するメソッド
    const navigation = useNavigate();

    const HandleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        // if (menuName !== "この食材はすでに登録されています。") {
        axios
            .post("http://localhost:8888/api/add_menu_register", menuData)
            .then((response) => {
                console.log(response.data);
                setMenuName(response.data);
                // if (response.data === "登録完了") {
                //     navigation("/Food/");
                // }
            })
            .catch((error) => {
                console.error(error);
            });
        // } else {
        //     HandleAddFood2();
        // }
    };
    //↑POST送信関係 ----------------------------------------------------------------------------------------------

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
                            placeholder={menuName || "メニュー名"}
                            onChange={OnChangeName}
                        />
                    </div>

                    {menuName === "メニュー名" || menuName === "" ? (
                        //  ||
                        // menuName === 0
                        <p>食材名を記入してください</p>
                    ) : (
                        <Button type="submit" isDisabled={!menuName}>
                            新規メニュー追加
                        </Button>
                    )}
                    {food &&
                        food.map((value) => (
                            <div key={value.id}>
                                <p>{value.name}</p>
                                <NumberInput min={0}>
                                    <NumberInputField />
                                    <NumberInputStepper>
                                        <NumberIncrementStepper />
                                        <NumberDecrementStepper />
                                    </NumberInputStepper>
                                </NumberInput>
                            </div>
                        ))}
                </form>
            </ChakraProvider>
        </>
    );
};

export default NewMenu;
