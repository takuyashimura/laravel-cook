import {
    Box,
    Button,
    Flex,
    StackDivider,
    Text,
    VStack,
    useToast,
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
    const toast = useToast();

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
                toast({
                    title: "不足している食材を買い物リストに追加しました。",
                    description: "買い物リストへ移動します",
                    status: "success",
                    duration: 9000,
                    isClosable: true,
                });
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
                toast({
                    title: "使用する食材を消費しました。",
                    description: "在庫数をご確認ください",
                    status: "success",
                    duration: 9000,
                    isClosable: true,
                });
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
                    {" "}
                    <Text m={2} fontSize={20} fontWeight={800}>
                        メニュー
                    </Text>
                    <VStack
                        divider={<StackDivider borderColor="gray.200" />}
                        spacing={2}
                        align="stretch"
                    >
                        {nameCount.map((c, index) => (
                            <Flex
                                ml={2}
                                mr={2}
                                justify="space-between"
                                key={index}
                            >
                                <Text>{c.name}</Text>
                                <Text>{c.count}人前</Text>
                            </Flex>
                        ))}{" "}
                        <Text m={2} fontSize={20} fontWeight={700}>
                            使用食材
                        </Text>
                    </VStack>
                    {useList && (
                        <VStack
                            divider={<StackDivider borderColor="gray.200" />}
                            spacing={2}
                            align="stretch"
                        >
                            {useList.map((u) => (
                                <Flex
                                    ml={2}
                                    mr={2}
                                    justify="space-between"
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
                <Box mt={"30px"} justifyContent="center" alignItems="center">
                    <Text fontSize={25} textAlign="center">
                        調理リストが空です
                    </Text>
                    <Text fontSize={25} textAlign="center">
                        メニューを追加してください
                    </Text>
                </Box>
            )}
            <form onSubmit={HandleSubmit}>
                {nonStocksData && onStocksData && !!length ? (
                    <>
                        <VStack
                            divider={<StackDivider borderColor="gray.200" />}
                            spacing={2}
                            align="stretch"
                        >
                            <Text m={2} fontSize={20} fontWeight={700}>
                                不足食材
                            </Text>

                            {nonStocksData.map((d) => (
                                <Flex
                                    justify="space-between"
                                    bg="yellow.200"
                                    key={d.id}
                                >
                                    <Text>{d.food_name}</Text>
                                    <Flex>
                                        <Text color={"red"}>{d.amount}</Text>
                                        <Text>個</Text>
                                    </Flex>{" "}
                                </Flex>
                            ))}
                            {onStocksData.map((d) => (
                                <Flex
                                    justify="space-between"
                                    bg="yellow.200"
                                    key={d.id}
                                >
                                    <Text>{d.food_name}</Text>
                                    <Flex>
                                        <Text color={"red"}>{d.amount}</Text>
                                        <Text>個</Text>
                                    </Flex>
                                </Flex>
                            ))}
                        </VStack>

                        <Button mt={5} ml={2} type="submit">
                            <Text>不足分を買い物リストに追加する</Text>
                        </Button>
                    </>
                ) : (
                    <>
                        {cookingList && cookingList.length > 0 && (
                            <Button mt={2} ml={2} onClick={HandlePost}>
                                調理をする
                            </Button>
                        )}
                    </>
                )}
            </form>
        </>
    );
};

export default CookingList;
