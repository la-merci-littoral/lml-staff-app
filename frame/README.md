# App

The App is built using the React Native framework.

To ease the creation of the app (as we weren't any React experts), we decided to use the Expo subframework.
This Node JS package allows creating one single app which can be deployed to both Android and iOS.

Expo can create android and iOS project directories as if you had been coding all along in IntelliJ Android Studio or XCode.

Expo also provide a cloud-based service called EAS (Expo Application Services).
This allows you to send using a single command your project's files to their servers who build the APK/IPA.
EAS also allows you directly submit to a Store.

Unfortunately, some of these building/submitting procedures aren't free :
* for Android, you can create and deploy the APK for free by sending it via email, etc... but putting it one the Play Store costs a one-time $25 fee
* for iOS, to build the IPA file, you *need* an Apple Developer Account, which costs $100 per year...Please note that even if you try to build it on a Mac using XCode instead of on the cloud using EAS, it will ask you to log into your Apple Developer account

It wood be good to find a solution to avoid the fees with the Apple Developer Program.

Apple proposes a Non-Profit program, which could definitely help to get a free Developer Account. To apply, you need to be a recognized non-profit association using a DUNS number.

The association we were helping in 2023 did not know its DUNS number, though you can request it by paying a one-time $15 fee. Explain to the association that this number can be useful to them in the future, and not just for us. Please take into account that once you have your DUNS number, it can take over 3 weeks from Apple to deliver you an account (if they approve).

The app is quite simple : a WebView component displays the website coded in the `app-www` repository.

A function transmits the use of the Android back (<kbd>↩</kbd>) button to the WebView.

Before the WebView load, UI elements' (such as the status bar, the navigation bar...) colors are modified to fit the splash screen.

Some changes could be made to improve the app :
* make a dark mode splash screen
* animated splash screen with blinking dots or a spinner wheel
