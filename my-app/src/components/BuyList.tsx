import {
    Box,
    Button,
    Flex,
    StackDivider,
    Text,
    Textarea,
    VStack,
    useDisclosure,
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

    const ToEditBuyList = () => {
        navigation("/editBuyList/");
    };

    return (
        <>
            <Button
                m={1}
                // onClick={ToEditBuyList}
                onClick={onEdit}
            >
                購入リストを編集する
            </Button>

            <form onSubmit={HnadleSubmit1}>
                <VStack
                    divider={<StackDivider borderColor="gray.200" />}
                    spacing={2}
                    align="stretch"
                >
                    {shoppingItems &&
                        shoppingItems.map((shoppingItem) => (
                            <Flex justify="space-between" bg="yellow.200">
                                <Text>{shoppingItem.name}</Text>
                                <Text>{shoppingItem.total_amount}個</Text>
                            </Flex>
                        ))}
                </VStack>
                {shoppingItems && shoppingItems.length > 0 && (
                    <Button m={5} type="submit">
                        購入する
                    </Button>
                )}

                {!shoppingItems && <p>購入リストは空です</p>}
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
                <Button m={5} type="submit">
                    メモを保存
                </Button>
            </form>
            <EditBuyListModal isOpen={isEdit} onClose={endEdit} />
        </>
    );
};
export default BuyList;
