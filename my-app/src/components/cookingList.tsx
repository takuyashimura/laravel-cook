import {
    Box,
    Button,
    Flex,
    StackDivider,
    Text,
    VStack,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

type cookingList = {
    id: number;
    name: string;
};

type StocksData = {
    id: number;
    food_name: string;
    amount: number;
};

type NameCount = {
    count: number;
    name: string;
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
    const [nameCount, setNameCount] = useState<NameCount[] | undefined>(
        undefined
    );
    const navigate = useNavigate();

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(
                    "http://localhost:8888/api/cooking_list"
                );
                console.log("res.data", res.data);
                setCookingList(res.data.cooking_list);
                setnonStocksData(res.data.non_stocks_data);
                setOonStocksData(res.data.on_stocks_data);
                setUseList(res.data.cooking_list_food_name_amount);
                setNameCount(res.data.cooking_list_name_count);
                console.log("nameCount", nameCount);

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
                navigate("/buylist/");
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const HandlePost = () => {
        axios
            .post("http://localhost:8888/api/cooking", { useList, cookingList })
            .then((response) => {
                console.log("帰ってきたお", response.data);
                navigate("/food/");
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const length = onStocksData?.length || nonStocksData?.length;

    return (
        <>
            {nameCount && nameCount.length > 0 ? (
                <>
                    <VStack
                        divider={<StackDivider borderColor="gray.200" />}
                        spacing={2}
                        align="stretch"
                    >
                        <Text fontSize={20} fontWeight={800}>
                            調理するメニュー
                        </Text>
                        {nameCount.map((c, index) => (
                            <Flex
                                justify="space-between"
                                bg="yellow.200"
                                key={index}
                            >
                                <Text>{c.name}</Text>
                                <Text>{c.count}人前</Text>
                            </Flex>
                        ))}
                    </VStack>

                    {useList && (
                        <VStack
                            divider={<StackDivider borderColor="gray.200" />}
                            spacing={2}
                            align="stretch"
                        >
                            <Text>使用する食材</Text>
                            {useList.map((u) => (
                                <Flex
                                    justify="space-between"
                                    bg="yellow.200"
                                    key={u.id}
                                >
                                    <Text>{u.food_name}</Text>
                                    <Text>{u.amount}個</Text>
                                </Flex>
                            ))}{" "}
                        </VStack>
                    )}
                </>
            ) : (
                <Flex align="center" justify="center">
                    <Text fontSize={25}>メニューを追加してください</Text>
                </Flex>
            )}
            <form onSubmit={HandleSubmit}>
                {nonStocksData && onStocksData && !!length ? (
                    <>
                        <Box>
                            <Text fontSize={20} fontWeight={700}>
                                不足食材名と分量
                            </Text>
                        </Box>
                        <VStack
                            divider={<StackDivider borderColor="gray.200" />}
                            spacing={2}
                            align="stretch"
                        >
                            {nonStocksData.map((d) => (
                                <Flex
                                    justify="space-between"
                                    bg="yellow.200"
                                    key={d.id}
                                >
                                    <Text>{d.food_name}</Text>
                                    <Text>{d.amount}個</Text>
                                </Flex>
                            ))}
                            {onStocksData.map((d) => (
                                <Flex
                                    justify="space-between"
                                    bg="yellow.200"
                                    key={d.id}
                                >
                                    <Text>{d.food_name}</Text>
                                    <Text>{d.amount}個</Text>
                                </Flex>
                            ))}
                        </VStack>

                        <Button m={5} type="submit">
                            <Text>不足分を買い物リストに追加する</Text>
                        </Button>
                    </>
                ) : (
                    <>
                        <Text>不足している食材はありません</Text>
                        {cookingList && cookingList.length > 0 && (
                            <Button onClick={HandlePost}>調理をする</Button>
                        )}
                    </>
                )}
            </form>
        </>
    );
};

export default CookingList;
