import {
    Button,
    Wrap,
    WrapItem,
    useDisclosure,
    useToast,
} from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useRef, useState } from "react";
import { useNavigate } from "react-router-dom";
import styled from "styled-components";

import NewFood from "./NewFood";
import { FoodToMenusModal } from "./FoodToMenusModal";
import { AlertDialogPage } from "./AlertDialogPage";
type FoodStocks = {
    id: number;
    name: string;
    total_amount: number;
};

type ModalFoodStocks = {
    id: number;
    name: string;
    total_amount: number;
    length: number;
};

type Modal = {
    id: number;
    name: string;
    total_amount: number;
};

const Food = () => {
    const [foodStocks, setFoodStocks] = useState<FoodStocks[] | undefined>(
        undefined
    );
    const [modalFoodStocks, setModalFoodStocks] = useState<
        ModalFoodStocks[] | undefined
    >(undefined);

    const [modaldata, setModalData] = useState<Modal[] | undefined>(undefined);

    const {
        isOpen: isOpenAddFoodModal,
        onOpen: onOpenAddFoodModal,
        onClose: CloseAddFoodModal,
    } = useDisclosure();
    const {
        isOpen: isOpenFoodToMenuModal,
        onOpen: onOpenFoodToMenuModal,
        onClose: CloseFoodToMenuModal,
    } = useDisclosure();
    const {
        isOpen: isCheck,
        onOpen: onCheck,
        onClose: endCheck,
    } = useDisclosure();

    // 先ほど作成したLaravelのAPIのURL
    const url = "http://localhost:8888/api/home";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);

                setFoodStocks(res.data.food_stocks);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);

    const onCheckOpen = (food_stock: any) => {
        axios
            .post("http://localhost:8888/api/foodCheck", food_stock)
            .then((response) => {
                if (
                    response.data ===
                    "メニューの材料として登録されているため削除できません"
                ) {
                    toast({
                        title: `${response.data}`,
                        status: "error",
                        isClosable: true,
                    });
                } else {
                    setModalData(food_stock);
                    console.log("modaldata", modaldata);
                    onCheck();
                }
                console.log("post", response.data);
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePostModal = (food_stock: any) => {
        axios
            .post("http://localhost:8888/api/foodToMenu", { food_stock })
            .then((response) => {
                console.log("post", response.data);
                setModalFoodStocks(response.data);
            })
            .catch((error) => {
                console.error(error);
            });
        onOpenFoodToMenuModal();
    };

    const toast = useToast();

    const navigate = useNavigate();

    return (
        <div className="Food">
            {/* <Button as={Link} to="/newFood/"> */}
            <Button onClick={onOpenAddFoodModal}>新規食材追加</Button>
            <Wrap>
                {foodStocks &&
                    foodStocks.map((food_stock) => (
                        <WrapItem key={food_stock.id}>
                            <SCord>
                                <p>{food_stock.name}</p>
                                <p>
                                    在庫数
                                    {food_stock.total_amount === null
                                        ? 0
                                        : food_stock.total_amount}
                                    個
                                </p>
                                <Button
                                    colorScheme="teal"
                                    onClick={() => handlePostModal(food_stock)}
                                    // onClick={() => handlePost(food_stock)}
                                    _hover={{
                                        cursor: "pointer",
                                        opacity: 0.8,
                                    }}
                                >
                                    選択
                                </Button>
                                <Button
                                    colorScheme="red"
                                    // onClick={() => handlePost1(food_stock)}
                                    onClick={() => onCheckOpen(food_stock)}
                                    _hover={{
                                        cursor: "pointer",

                                        opacity: 0.8,
                                    }}
                                >
                                    削除
                                </Button>
                            </SCord>
                        </WrapItem>
                    ))}
            </Wrap>
            <NewFood isOpen={isOpenAddFoodModal} onClose={CloseAddFoodModal} />
            <FoodToMenusModal
                isOpen={isOpenFoodToMenuModal}
                onClose={CloseFoodToMenuModal}
                modalFoodStocks={modalFoodStocks}
            />
            <AlertDialogPage
                isOpen={isCheck}
                onClose={endCheck}
                modaldata={modaldata}
            />
        </div>
    );
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Food;
