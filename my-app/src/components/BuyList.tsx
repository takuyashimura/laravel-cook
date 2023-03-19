import {
    Box,
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

                setShoppingItems(res.data.shopping_items);
                setText(res.data.text);
                console.log(res.data);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);

    const onChangeText = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setText(e.target.value);
    };

    return (
        <ChakraProvider>
            <VStack
                divider={<StackDivider borderColor="gray.200" />}
                spacing={4}
                align="stretch"
            >
                {shoppingItems &&
                    shoppingItems.map((shoppingItem) => (
                        <Box h="40px" bg="yellow.200">
                            <p>{shoppingItem.name}</p>
                            <p>{shoppingItem.total_amount}</p>
                        </Box>
                    ))}
            </VStack>
            <Textarea
                resize="vertical"
                minH="200px"
                maxH="400px"
                placeholder="その他買い物メモ"
                onChange={onChangeText}
            />
        </ChakraProvider>
    );
};
export default BuyList;
