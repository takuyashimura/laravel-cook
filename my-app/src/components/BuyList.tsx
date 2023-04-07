import {
    Box,
    Button,
    Flex,
    StackDivider,
    Text,
    Textarea,
    VStack,
    useDisclosure,
    useToast,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { EditBuyListModal } from "./EditbuyListModal";

type shopingItem = {
    food_id: number;
    name: string;
    total_amount: number;
};
type Text = string;

const BuyList = () => {
    const [shoppingItems, setShoppingItems] = useState<
        shopingItem[] | undefined
    >(undefined);
    const [text, setText] = useState<Text>();

    const {
        isOpen: isEdit,
        onOpen: onEdit,
        onClose: endEdit,
    } = useDisclosure();

    const toast = useToast();

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(
                    "http://localhost:8888/api/buy_list"
                );
                console.log("res.data", res.data);
                setShoppingItems(res.data.shopping_items);
                setText(res.data.texts[0].text);
                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    const HnadleSubmit1 = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/boughtFood", shoppingItems)
            .then((response) => {
                console.log("shoppingItems", shoppingItems);
                toast({
                    title: "在庫に追加しました",
                    description: "食材ページで在庫数をご確認ください",
                    status: "success",
                    duration: 9000,
                    isClosable: true,
                });
                navigation("/Food/");
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const HnadleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/text", text)
            .then((response) => {
                console.log("post", response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const navigation = useNavigate();

    return (
        <>
            <Button m={2} onClick={onEdit}>
                購入リストを編集する
            </Button>

            <form onSubmit={HnadleSubmit1}>
                <VStack
                    divider={<StackDivider borderColor="gray.200" />}
                    spacing={2}
                    align="stretch"
                    mr={2}
                    ml={2}
                >
                    {shoppingItems &&
                        shoppingItems.map((shoppingItem) => (
                            <Flex justify="space-between">
                                <Text>{shoppingItem.name}</Text>
                                <Text>{shoppingItem.total_amount}個</Text>
                            </Flex>
                        ))}
                </VStack>
                {shoppingItems && shoppingItems.length > 0 && (
                    <Button m={5} ml={2} type="submit">
                        購入する
                    </Button>
                )}
            </form>

            <form onSubmit={HnadleSubmit}>
                <Textarea
                    bgColor={"gray.50"}
                    resize="vertical"
                    minH="200px"
                    maxH="400px"
                    placeholder="その他買い物メモ"
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                />
                <Button m={5} ml={2} type="submit">
                    メモを保存
                </Button>
            </form>
            <EditBuyListModal isOpen={isEdit} onClose={endEdit} />
        </>
    );
};
export default BuyList;
