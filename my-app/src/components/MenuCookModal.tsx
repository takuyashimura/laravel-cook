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
    useToast,
} from "@chakra-ui/react";
import axios from "axios";
import { FC, memo } from "react";

type Props = {
    isOpen: boolean;
    onClose: () => void;
    choiceMenu: any;
};

export const MenuCookModal: FC<Props> = memo((props) => {
    const { isOpen, onClose, choiceMenu } = props;

    const toast = useToast();

    const handlePost = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add_buy_list", choiceMenu)
            .then((response) => {
                console.log("post", response.data);
                toast({
                    title: "不足している食材が買い物リストに追加されました",
                    description: "買い物リストをご確認ください",
                    status: "success",
                    duration: 9000,
                    isClosable: true,
                });
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
                toast({
                    title: `${choiceMenu[1]["name"]}が調理リストに追加されました`,
                    description: "調理リストをご確認ください",
                    status: "success",
                    duration: 9000,
                    isClosable: true,
                });
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
                            <Box fontWeight={700}>不足数</Box>
                            <form onSubmit={handlePost}>
                                <VStack
                                    divider={
                                        <StackDivider borderColor="gray.200" />
                                    }
                                    spacing={1}
                                    align="stretch"
                                >
                                    {choiceMenu && choiceMenu[0].length > 0 ? (
                                        choiceMenu[0].map((f: any) => (
                                            <Flex
                                                justify="space-between"
                                                key={f.id}
                                            >
                                                <Text>{f.name}</Text>
                                                <Flex>
                                                    <Text color={"red"}>
                                                        {f.food_amount}
                                                    </Text>
                                                    <Text>個</Text>
                                                </Flex>
                                            </Flex>
                                        ))
                                    ) : (
                                        <Text>不足分はありません</Text>
                                    )}

                                    {choiceMenu && choiceMenu[0].length > 0 && (
                                        <Box w={"100%"} textAlign={"right"}>
                                            <Button type="submit">
                                                買い物リストに追加する
                                            </Button>{" "}
                                        </Box>
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
                                                key={f.food_id}
                                            >
                                                <Text>{f.name}</Text>
                                                <Text>{f.food_amount}個</Text>
                                            </Flex>
                                        </>
                                    ))}
                            </VStack>
                        </div>
                        <Box w={"100%"} textAlign={"right"}>
                            {" "}
                            <Button onClick={handlePost1}>
                                調理リストへ追加する
                            </Button>
                        </Box>
                    </>
                </ModalBody>
            </ModalContent>
        </Modal>
    );
});
