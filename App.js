import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { SafeAreaView, StyleSheet } from 'react-native';
import PaisesScreen from './Screens/PaisesScreen';
import CidadesScreen from './Screens/CidadesScreen';

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <SafeAreaView style={styles.container}>
      <NavigationContainer>
        <Stack.Navigator>
          <Stack.Screen name="Paises" component={PaisesScreen} />
          <Stack.Screen name="Cidades" component={CidadesScreen} />
        </Stack.Navigator>
      </NavigationContainer>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f5f5f5' },
});
