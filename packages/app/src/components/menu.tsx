import { Text, StyleSheet, TouchableOpacity, View, ViewStyle, StyleProp } from "react-native";
import { Colors } from "@/constants/Colors";
import { LucideIcon } from "lucide-react-native";

export type MenuItemProps = {
    icon: LucideIcon;
    iconSize?: number;
    label: string;
    onPress: () => void;
    style?: StyleProp<ViewStyle>;
}

function MenuItem(props: MenuItemProps) {

    const styles = StyleSheet.create({
        menuItem: {
            padding: 10,
            backgroundColor: Colors.cadet,
            borderRadius: 10,
            borderColor: Colors.argentinian,
            borderWidth: 1,
            width: "100%",
            fontFamily: "Nunito_400Regular",
            display: "flex",
            flexDirection: "column",
            alignItems: "center",
            justifyContent: "center",
            gap: 10,
            flexGrow: 1,
            maxHeight: 200
        },
        menuLabel: {
            color: Colors.pale,
            fontFamily: "Nunito_400Regular",
            fontSize: props.style ? ((props.style as any).fontSize ? (props.style as any).fontSize : 20 ) : 20,
            textAlign: "center",
        }
    })

    // Assign the icon component to a capitalized variable
    const IconComponent = props.icon;

    return (
        <TouchableOpacity style={[styles.menuItem, props.style]} onPress={props.onPress}>
            <IconComponent size={props.iconSize ? props.iconSize : 60} color={Colors.pale} />
            <Text style={styles.menuLabel}>{props.label}</Text>
        </TouchableOpacity>
    );
}

export default function Menu({items}: {items: MenuItemProps[]}) {
    return (
        <View style={styles.menuList}>
            {items.map((item, index) => (
                <MenuItem
                    key={index}
                    {...item}
                />
            ))}
        </View>
    )
}

Menu.Item = MenuItem

const styles = StyleSheet.create({
    menuList: {
        width: "100%",
        maxWidth: 400,
        display: "flex",
        flexDirection: "column",
        justifyContent: "space-evenly",
        gap: 15,
        marginBottom: 20,
        flexGrow: 1
    }
});