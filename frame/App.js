/* import * as React from 'react'; */
import React, { useState, useEffect, useRef } from 'react';
import { Text, View, StyleSheet, BackHandler } from 'react-native';
import { WebView } from 'react-native-webview'; // imports the webview component
import { Camera } from 'expo-camera'; // imports the camera component to interact with the camera
import * as NavigationBar from 'expo-navigation-bar'; // allows control of the bottom Android navigation bar
import * as StatusBar from 'expo-status-bar'; // allows control of the top status bar
import * as SplashScreen from 'expo-splash-screen'; // controls the app start screen

export default function App() {
  const [hasPermission, setHasPermission] = useState(null);
  const [type, setType] = useState(Camera.Constants.Type.back);
  const webViewRef = useRef(null);
  SplashScreen.preventAutoHideAsync(); // keeps the splash screen on display
  NavigationBar.setBackgroundColorAsync('white') // sets the colors
  NavigationBar.setButtonStyleAsync('dark')      // of the bottom bar
  StatusBar.setStatusBarBackgroundColor('white', false) // sets the color of the top bar and removes translucent material
  StatusBar.setStatusBarStyle('dark')
  StatusBar.setStatusBarTranslucent(false)

  const finishedLoading = async () => { // runs when the WebView has finished loading
    setTimeout(function(){
      // reverts all the changes made above
      NavigationBar.setBackgroundColorAsync('#0b142c')
      NavigationBar.setButtonStyleAsync('light')
      SplashScreen.hideAsync()
      StatusBar.setStatusBarBackgroundColor('#0b142c', false)
      StatusBar.setStatusBarStyle('light')
      StatusBar.setStatusBarTranslucent(false)
    }, 3000) // adds a delay of 3 seconds
  }

  useEffect(() => {
    (async () => {
      const { status } = await Camera.requestCameraPermissionsAsync(); // requests Camera permissions using the OS query box
      setHasPermission(status === 'granted');
    })();
  }, []);
  useEffect(() => {
    const backAction = () => {
      webViewRef.current.goBack(); // sends 'back' signal to the WebView
      return true;
    };

    const backHandler = BackHandler.addEventListener(
      'hardwareBackPress',
      backAction // back button means 'back' in the WebView
    );

    return () => backHandler.remove();
  }, []);

  if (hasPermission === null) {
    return <View />; // empty if no permission information
  }
  if (hasPermission === false) {
    return <Text>No access to camera</Text>;
  }


  return (

    <View style={styles.container}>
      <WebView
        source={{ uri: 'https://app-www.ronde-de-l-espoir.fr/login/login.php' }} // the WebView URL
        ref={webViewRef}
        style={styles.view}
        originWhitelist={['*']}
        allowsInlineMediaPlayback
        javaScriptEnabled // enables JS
        scalesPageToFit // scales the page to fit screen size
        mediaPlaybackRequiresUserAction={false} // auto media launching
        javaScriptEnabledAndroid
        useWebkit
        startInLoadingState={true}
        onLoad={finishedLoading} // once it's finished loading, run the finishedLoading function
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1, // aligns the WebView in the center
  }
});
