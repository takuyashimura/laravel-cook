import {
    Box,
    Button,
    Modal,
    ModalBody,
    ModalCloseButton,
    ModalContent,
    ModalHeader,
    ModalOverlay,
    NumberDecrementStepper,
    NumberIncrementStepper,
    NumberInput,
    NumberInputField,
    NumberInputStepper,
    StackDivider,
    VStack,
} from "@chakra-ui/react";
import axios from "axios";
import { VFC, memo, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

type Props = { isOpen: boolean; onClose: () => void };

type Nonfood = {
    id: number;
    name: string;
};
type ShoppingItem = {
    food_id: number;
    name: string;
    amount: number;
};

export const EditBuyListModal: VFC<Props> = memo((props) => {
    const { isOpen, onClose } = props;
    const [nonFood, setNonFood] = useState<[Nonfood] | undefined>(undefined);
    const [sList, setSList] = useState<ShoppingItem[] | undefined>(undefined);

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(
                    "http://localhost:8888/api/edit_buy_list"
                );
                console.log("res.data", res.data);
                setNonFood(res.data.nonFood);
                setSList(res.data.shopping_item);
                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    const nonFoodArray = nonFood?.flat();

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/reply_buy_list", sList)
            .then((response) => {
                console.log("post", response.data);
                onClose();
                window.location.reload();
                // navigation("/buyList/");
            })
            .catch((error) => {
                console.error(error);
            });
    };
    const onChangeFoodNumber = (e: string, name: string, food_id: number) => {
        if (sList?.some((d) => d.food_id === food_id)) {
            const updatedsList = sList.map((list) =>
                list.food_id === food_id
                    ? { food_id, name, amount: Number(e) }
                    : list
            );
            setSList(updatedsList);
        } else {
            setSList([
                ...(sList ? sList : []),
                {
                    food_id,
                    name,
                    amount: Number(e),
                },
            ]);
        }
    };
    console.log("sList", sList);
    const navigation = useNavigate();

    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <ModalOverlay />
            <ModalContent>
                <ModalHeader>購入リストの編集</ModalHeader>
                <ModalCloseButton />
                <ModalBody>
                    {" "}
                    <form onSubmit={handleSubmit}>
                        <Button type="submit">買い物リストを更新する</Button>
                        <VStack
                            divider={<StackDivider borderColor="gray.200" />}
                            spacing={4}
                            align="stretch"
                        >
                            {nonFoodArray &&
                                nonFoodArray.map((f) => (
                                    <>
                                        <Box
                                            key={f.id}
                                            h="40px"
                                            bg="yellow.200"
                                        >
                                            <p>{f.name}</p>
                                        </Box>
                                        <NumberInput
                                            min={0}
                                            onChange={(e) =>
                                                onChangeFoodNumber(
                                                    e,
                                                    f.name,
                                                    f.id
                                                )
                                            }
                                        >
                                            <NumberInputField />
                                            <NumberInputStepper>
                                                <NumberIncrementStepper />
                                                <NumberDecrementStepper />
                                            </NumberInputStepper>
                                        </NumberInput>
                                    </>
                                ))}
                            {sList &&
                                sList.map((l) => (
                                    <>
                                        <Box
                                            key={l.food_id}
                                            h="40px"
                                            bg="yellow.200"
                                        >
                                            <p>{l.name}</p>
                                        </Box>
                                        <NumberInput
                                            defaultValue={l.amount}
                                            onChange={(e) =>
                                                onChangeFoodNumber(
                                                    e,
                                                    l.name,
                                                    l.food_id
                                                )
                                            }
                                        >
                                            <NumberInputField />
                                            <NumberInputStepper>
                                                <NumberIncrementStepper />
                                                <NumberDecrementStepper />
                                            </NumberInputStepper>
                                        </NumberInput>
                                    </>
                                ))}
                        </VStack>
                    </form>
                </ModalBody>
            </ModalContent>
        </Modal>
    );
});
