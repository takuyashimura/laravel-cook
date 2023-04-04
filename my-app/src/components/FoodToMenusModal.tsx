import {
    Button,
    Modal,
    ModalBody,
    ModalCloseButton,
    ModalContent,
    ModalHeader,
    ModalOverlay,
} from "@chakra-ui/react";
import axios from "axios";
import { VFC, memo } from "react";
import { useNavigate } from "react-router-dom";
type ModalFoodStocks = {
    id: number;
    name: string;
    total_amount: number;
    length: number;
};

type Props = {
    isOpen: boolean;
    onClose: () => void;
    modalFoodStocks: ModalFoodStocks[] | undefined;
};

export const FoodToMenusModal: VFC<Props> = memo((props) => {
    console.log("props", props);
    const { isOpen, onClose, modalFoodStocks } = props;
    const navigate = useNavigate();

    if (modalFoodStocks) {
        console.log("modalFoodStocks", modalFoodStocks[0]);
        console.log("modalFoodStocks", modalFoodStocks[1].length);
        const length = modalFoodStocks[1].length;
        console.log("length", !!length);
    }

    const onClickFpodData = (d: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu: d })
            .then((response) => {
                console.log("post", response.data);
                navigate("/MenuCook/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };
    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <ModalOverlay />
            <ModalContent>
                <ModalHeader>
                    <div>
                        <h1>
                            {modalFoodStocks &&
                                modalFoodStocks[0] &&
                                `${modalFoodStocks[0]}を使うメニュー`}
                        </h1>
                    </div>
                </ModalHeader>
                <ModalCloseButton />
                <ModalBody>
                    <div>
                        {modalFoodStocks &&
                        Array.isArray(modalFoodStocks[1]) &&
                        modalFoodStocks[1].length > 0 ? (
                            modalFoodStocks[1].map((d: any) => (
                                <Button
                                    key={d.id}
                                    onClick={() => onClickFpodData(d)}
                                >
                                    <p>{d.name}</p>
                                </Button>
                            ))
                        ) : (
                            <p>使用するメニューがありません</p>
                        )}
                    </div>
                </ModalBody>
            </ModalContent>
        </Modal>
    );
});
