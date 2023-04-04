import {
    Box,
    Button,
    Modal,
    ModalBody,
    ModalCloseButton,
    ModalContent,
    ModalHeader,
    ModalOverlay,
    StackDivider,
    VStack,
    Text,
    Flex,
} from "@chakra-ui/react";
import axios from "axios";
import { VFC, memo } from "react";

type Props = {
    isOpen: boolean;
    onClose: () => void;
    choiceMenu: any;
};

export const MenuCookModal: VFC<Props> = memo((props) => {
    const { isOpen, onClose, choiceMenu } = props;
    if (choiceMenu) {
        console.log("choiceMenu", choiceMenu);
    }

    const handlePost = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add_buy_list", choiceMenu)
            .then((response) => {
                console.log("post", response.data);
                onClose();
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePost1 = () => {
        axios
            .post("http://localhost:8888/api/add_cooking_list", choiceMenu[1])
            .then((response) => {
                console.log("response", response.data);
                onClose();
            })
            .catch((error) => {
                console.log("error", error);
            });
    };

    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <ModalOverlay />
            <ModalContent>
                <ModalHeader>{choiceMenu && choiceMenu[1]["name"]}</ModalHeader>
                <ModalCloseButton />
                <ModalBody>
                    <>
                        <div>
                            <Button onClick={handlePost1}>
                                調理リストへ追加する
                            </Button>
                            <Box fontWeight={700}>不足数</Box>
                            <form onSubmit={handlePost}>
                                <VStack
                                    divider={
                                        <StackDivider borderColor="gray.200" />
                                    }
                                    spacing={1}
                                    align="stretch"
                                >
                                    {choiceMenu && choiceMenu[0] ? (
                                        choiceMenu[0].map((f: any) => (
                                            <Flex
                                                justify="space-between"
                                                bg={"red.50"}
                                                key={f.id}
                                            >
                                                <Text>{f.name}</Text>
                                                <Text>{f.food_amount}個</Text>
                                            </Flex>
                                        ))
                                    ) : (
                                        <Text>不足分はありません</Text>
                                    )}

                                    {choiceMenu && choiceMenu[0] && (
                                        <Button type="submit">
                                            購入リストに追加する
                                        </Button>
                                    )}
                                </VStack>
                            </form>
                        </div>
                        <div>
                            <Box fontWeight={700}>使用食材</Box>
                            <VStack
                                divider={
                                    <StackDivider borderColor="gray.200" />
                                }
                                spacing={1}
                                align="stretch"
                            >
                                {choiceMenu &&
                                    choiceMenu[2].map((f: any) => (
                                        <>
                                            <Flex
                                                justify="space-between"
                                                bg={"teal.50"}
                                                key={f.food_id}
                                            >
                                                <Text>{f.name}</Text>
                                                <Text>{f.food_amount}個</Text>
                                            </Flex>
                                        </>
                                    ))}
                            </VStack>
                        </div>
                    </>
                </ModalBody>
            </ModalContent>
        </Modal>
    );
});
