import {
    Box,
    Button,
    ChakraProvider,
    NumberDecrementStepper,
    NumberIncrementStepper,
    NumberInput,
    NumberInputField,
    NumberInputStepper,
    StackDivider,
    VStack,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";

type MenuName = {
    id: number;
    name: string;
};

type MenuData = {
    id: number;
    name: string;
    food_amount: number;
};

const EditMenu = () => {
    const [menuName, setMenuName] = useState<MenuName[] | undefined>(undefined);
    const [menuData, setMenuData] = useState<MenuData[] | undefined>(undefined);
    const navigation = useNavigate();
    const location = useLocation();
    console.log("location.state", location.state);

    useEffect(() => {
        setMenuName(location.state.menuData);
        setMenuData(location.state.foodArray);
    }, []);
    console.log("menuName", menuName);
    console.log("menuData", menuData);

    const onChangeFoodNumber = (e: string, name: string, foodId: number) => {
        if (menuData?.some((d) => d.id === foodId)) {
            const updatedMenuData = menuData.map((data) =>
                data.id === foodId
                    ? { id: foodId, name, food_amount: Number(e) }
                    : data
            );
            setMenuData(updatedMenuData);
        } else {
            setMenuData([
                ...(menuData ? menuData : []),
                {
                    id: foodId,
                    name,
                    food_amount: Number(e),
                },
            ]);
        }
    };

    const handlePost = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add_menu_edit", {
                menuName,
                menuData,
            })
            .then((response) => {
                console.log("post", response.data);
                navigation("/Menu/");
            })
            .catch((error) => {
                console.error(error);
            });
    };

    return (
        <>
            <ChakraProvider>
                <div>
                    <h1>
                        {menuName && menuName.length > 0 && menuName[0].name}
                    </h1>
                </div>
                <form onSubmit={handlePost}>
                    <Button type="submit"> 使用する食材を変更する </Button>
                    <VStack
                        divider={<StackDivider borderColor="gray.200" />}
                        spacing={4}
                        align="stretch"
                    >
                        {menuData &&
                            menuData.length > 0 &&
                            menuData.map((m) => (
                                <>
                                    <Box key={m.id} h="40px" bg="yellow.200">
                                        <p>{m.name}</p>
                                    </Box>
                                    <NumberInput
                                        defaultValue={m.food_amount}
                                        min={0}
                                        onChange={(e) =>
                                            onChangeFoodNumber(e, m.name, m.id)
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
            </ChakraProvider>
        </>
    );
};
export default EditMenu;
