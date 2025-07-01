import { Text, View, Button, StyleSheet, TouchableOpacity, Platform } from "react-native";
import useStaffStore from "@/stores/staffStore";
import { Href, router } from "expo-router";
import { Colors } from "@/constants/Colors";
import { useEffect } from "react";
import {  LogOut, LucideIcon, TicketCheck, UserSearch, CalendarPlus2, Undo2 } from "lucide-react-native";
import type React from "react";
import Menu, { MenuItemProps } from "@/components/menu";

export default function Index() {

    const { logout, token } = useStaffStore();

    useEffect(() => { }, [useStaffStore(state => state.token)]);
    if (!token) {
        return (
            <Text>Loading...</Text>
        )
    }

    return (
        <View style={styles.container}>
            <View style={styles.wrapper}>
                <Text style={styles.title}>Evènements</Text>
                <Menu 
                    items={[
                        {
                            icon: TicketCheck,
                            label: "Vérification de tickets",
                            onPress: () => router.push("/events/ticket-verification"),
                        },
                        {
                            icon: CalendarPlus2,
                            label: "Ajout d'événements",
                            onPress: logout,
                        },
                        ... Platform.OS == "ios" ? [{
                            icon: Undo2,
                            label: "Retour",
                            onPress: () => router.back()
                        }] : []
                    ]}
                />
            </View>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        alignItems: 'center',
        backgroundColor: Colors.lapis,
        height: "100%",
    },
    wrapper: {
        width: "90%",
        alignItems: "center",
        height: "100%",
    },
    title: {
        fontSize: 26,
        marginBottom: 20,
        color: Colors.pale,
        fontFamily: "Nunito_400Regular",
    }
});
