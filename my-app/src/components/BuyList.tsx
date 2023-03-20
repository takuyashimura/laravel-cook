import {
    Box,
    Button,
    ChakraProvider,
    StackDivider,
    Textarea,
    VStack,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";

type shopingItem = {
    food_id: number;
    name: string;
    total_amount: number;
};
type Text = string;

const BuyList = () => {
    const [shoppingItems, setShoppingItems] = useState<
        [shopingItem] | undefined
    >(undefined);
    const [text, setText] = useState<Text>();

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
            .post("http://localhost:8888/api/reply_buy_list", shoppingItems)
            .then((response) => {
                console.log("shoppingItems", shoppingItems);
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

    const onChangeText = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setText(e.target.value);
    };
    // console.log("text");

    return (
        <ChakraProvider>
            <form onSubmit={HnadleSubmit1}>
                <VStack
                    divider={<StackDivider borderColor="gray.200" />}
                    spacing={4}
                    align="stretch"
                >
                    {shoppingItems ? (
                        shoppingItems.map((shoppingItem) => (
                            <>
                                <Box h="40px" bg="yellow.200">
                                    <p>{shoppingItem.name}</p>
                                    <p>{shoppingItem.total_amount}</p>
                                </Box>
                            </>
                        ))
                    ) : (
                        <p>購入リストは空です</p>
                    )}

                    {shoppingItems && <Button type="submit">購入する</Button>}
                </VStack>
            </form>

            <form onSubmit={HnadleSubmit}>
                <Textarea
                    resize="vertical"
                    minH="200px"
                    maxH="400px"
                    placeholder="その他買い物メモ"
                    value={text}
                    onChange={onChangeText}
                />
                <Button type="submit">メモを保存</Button>
            </form>
        </ChakraProvider>
    );
};
export default BuyList;
