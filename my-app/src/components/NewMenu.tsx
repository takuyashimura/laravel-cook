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

type Food = {
    id: number;
    name: string;
};

type MenuFood = {
    foodId: number;
    amount: number;
};

const NewMenu = () => {
    //↓GET受信関係 ----------------------------------------------------------------------------------------------
    const [food, setFood] = useState<Food[] | undefined>(undefined);

    const url = "http://localhost:8888/api/add_menu";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);

                setFood(res.data.food);
                console.log("food", food);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    console.log("food２", food);
    //↑GET受信関係 ----------------------------------------------------------------------------------------------

    //↓POST送信関係 ----------------------------------------------------------------------------------------------
    const [menuName, setMenuName] = useState<MenuName>();

    const [menuData, setMenuData] = useState<MenuFood[] | undefined>(undefined);

    const [postData, setPostData] = useState([menuName, menuData]);

    const OnChangeName = (e: React.ChangeEvent<HTMLInputElement>) => {
        setMenuName(e.target.value);
    };

    const onChangeFoodNumber = (e: string, foodId: number) => {
        // foodの存在チェック
        if (menuData?.some((d) => d.foodId === foodId)) {
            const updatedMenuData = menuData.map((menu) =>
                menu.foodId === foodId ? { foodId, amount: Number(e) } : menu
            );
            setMenuData(updatedMenuData);

            // 存在しない場合
        } else {
            setMenuData([
                ...(menuData ? menuData : []),
                {
                    foodId,
                    amount: 1,
                },
            ]);
        }
    };
    useEffect(() => {
        setPostData([menuName, menuData]);
    }, [menuName, menuData]);

    //メニューが登録できた際の画面推移に使用するメソッド
    const navigation = useNavigate();

    const HandleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        // if (menuName !== "この食材はすでに登録されています。") {
        axios
            .post("http://localhost:8888/api/add_menu_register", postData)
            .then((response) => {
                console.log("post", response.data);
                if (response.data === "登録完了") {
                    navigation("/menu/");
                } else {
                    HandleAddFood2();
                }
            })
            .catch((error) => {
                console.error(error);
            });
        const HandleAddFood2 = () => {
            toast({
                title: "既に登録されています",
                description: "メニューページを確認してください",
                status: "error",
                duration: 9000,
                isClosable: true,
            });
        };
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
                        food.map((f) => (
                            <div key={f.id}>
                                <p>{f.name}</p>
                                <NumberInput
                                    min={0}
                                    onChange={(e) =>
                                        onChangeFoodNumber(e, f.id)
                                    }
                                >
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
