import {
    AlertDialog,
    AlertDialogBody,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogContent,
    AlertDialogOverlay,
    Button,
} from "@chakra-ui/react";
import axios from "axios";
import React, { VFC, memo, useRef } from "react";

type Props = { isOpen: boolean; onClose: () => void; modaldata: any };

export const AlertDialogPage: VFC<Props> = memo((props) => {
    const { isOpen, onClose, modaldata } = props;
    const cancelRef = useRef<HTMLButtonElement | null>(null);

    const handlePost1 = (modaldata: any) => {
        axios
            .post("http://localhost:8888/api/food_delete", { modaldata })
            .then((response) => {
                console.log("response", response.data);
                onClose();
                window.location.reload();
            })
            .catch((error) => {
                console.error(error);
            });
    };

    console.log("modaldata", modaldata);

    return (
        <>
            <AlertDialog
                motionPreset="slideInBottom"
                leastDestructiveRef={cancelRef}
                onClose={onClose}
                isOpen={isOpen}
                isCentered
            >
                <AlertDialogOverlay />

                <AlertDialogContent>
                    <AlertDialogHeader>削除確認</AlertDialogHeader>
                    <AlertDialogBody>
                        {modaldata &&
                            `${modaldata.name}を削除します。
                        よろしいでしょうか？`}
                    </AlertDialogBody>
                    <AlertDialogFooter>
                        <Button ref={cancelRef} onClick={onClose}>
                            いいえ
                        </Button>
                        <Button
                            colorScheme="red"
                            ml={3}
                            onClick={() => handlePost1(modaldata)}
                        >
                            はい
                        </Button>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
});