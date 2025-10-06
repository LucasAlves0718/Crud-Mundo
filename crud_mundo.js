
import React, { useEffect, useState } from 'react';
import { SafeAreaView, View, Text, FlatList, TextInput, TouchableOpacity, StyleSheet, ActivityIndicator, Alert, Modal } from 'react-native';

const API_BASE_URL = 'http://10.0.2.2/draftme/api'; // <- ajustar para seu ambiente (emulador Android use 10.0.2.2)

export default function App() {
  const [paises, setPaises] = useState([]);
  const [loading, setLoading] = useState(false);
  const [modalVisible, setModalVisible] = useState(false);
  const [editingPais, setEditingPais] = useState(null);
  const [nomePais, setNomePais] = useState('');

  useEffect(() => {
    fetchPaises();
  }, []);

  async function fetchPaises() {
    setLoading(true);
    try {
      const res = await fetch(`${API_BASE_URL}/paises.php`);
      const json = await res.json();
      // Espera-se formato: [{ id: 1, nome: 'Brasil', continente: 'América' }, ...]
      setPaises(json);
    } catch (err) {
      Alert.alert('Erro', 'Não foi possível carregar países. ' + err.message);
    } finally {
      setLoading(false);
    }
  }

  async function salvarPais() {
    if (!nomePais.trim()) {
      Alert.alert('Validação', 'Informe o nome do país.');
      return;
    }

    const payload = { nome: nomePais };

    try {
      let res;
      if (editingPais) {
        // Atualizar
        res = await fetch(`${API_BASE_URL}/paises.php?id=${editingPais.id}`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        });
      } else {
        // Criar
        res = await fetch(`${API_BASE_URL}/paises.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        });
      }

      const data = await res.json();
      if (data.success) {
        fetchPaises();
        fecharModal();
      } else {
        Alert.alert('Erro', data.message || 'Erro no servidor');
      }
    } catch (err) {
      Alert.alert('Erro', err.message);
    }
  }

  async function excluirPais(id) {
    Alert.alert('Confirmação', 'Excluir este país?', [
      { text: 'Cancelar', style: 'cancel' },
      { text: 'Excluir', style: 'destructive', onPress: async () => {
        try {
          const res = await fetch(`${API_BASE_URL}/paises.php?id=${id}`, { method: 'DELETE' });
          const data = await res.json();
          if (data.success) fetchPaises();
          else Alert.alert('Erro', data.message || 'Falha ao excluir');
        } catch (err) {
          Alert.alert('Erro', err.message);
        }
      } }
    ]);
  }

  function abrirModalNovo() {
    setEditingPais(null);
    setNomePais('');
    setModalVisible(true);
  }

  function abrirModalEditar(pais) {
    setEditingPais(pais);
    setNomePais(pais.nome);
    setModalVisible(true);
  }

  function fecharModal() {
    setModalVisible(false);
    setEditingPais(null);
    setNomePais('');
  }

  function renderPais({ item }) {
    return (
      <View style={styles.item}>
        <View style={{ flex: 1 }}>
          <Text style={styles.itemTitle}>{item.nome}</Text>
          <Text style={styles.itemSubtitle}>{item.continente || '—'}</Text>
        </View>
        <TouchableOpacity style={styles.smallBtn} onPress={() => abrirModalEditar(item)}>
          <Text style={styles.smallBtnText}>Editar</Text>
        </TouchableOpacity>
        <TouchableOpacity style={[styles.smallBtn, { backgroundColor: '#f44336' }]} onPress={() => excluirPais(item.id)}>
          <Text style={styles.smallBtnText}>Excluir</Text>
        </TouchableOpacity>
        <TouchableOpacity style={[styles.smallBtn, { backgroundColor: '#2196f3' }]} onPress={() => {
          // Navegar para tela de cidades — aqui só demonstramos com alerta
          Alert.alert('Cidades', `Abrir cidades do país: ${item.nome}`);
        }}>
          <Text style={styles.smallBtnText}>Cidades</Text>
        </TouchableOpacity>
      </View>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.title}>CRUD Mundo</Text>
        <TouchableOpacity style={styles.btn} onPress={abrirModalNovo}>
          <Text style={styles.btnText}>Novo País</Text>
        </TouchableOpacity>
      </View>

      {loading ? (
        <ActivityIndicator size="large" />
      ) : (
        <FlatList
          data={paises}
          keyExtractor={p => String(p.id)}
          renderItem={renderPais}
          ItemSeparatorComponent={() => <View style={{ height: 8 }} />}
          contentContainerStyle={{ padding: 12 }}
        />
      )}

      <Modal visible={modalVisible} animationType="slide" transparent>
        <View style={styles.modalOverlay}>
          <View style={styles.modalContent}>
            <Text style={styles.modalTitle}>{editingPais ? 'Editar País' : 'Novo País'}</Text>
            <TextInput placeholder="Nome do país" value={nomePais} onChangeText={setNomePais} style={styles.input} />

            <View style={{ flexDirection: 'row', justifyContent: 'flex-end' }}>
              <TouchableOpacity style={[styles.btn, { marginRight: 8 }]} onPress={fecharModal}>
                <Text style={styles.btnText}>Cancelar</Text>
              </TouchableOpacity>
              <TouchableOpacity style={styles.btn} onPress={salvarPais}>
                <Text style={styles.btnText}>{editingPais ? 'Salvar' : 'Criar'}</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </Modal>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f5f5f5' },
  header: { padding: 12, flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between', backgroundColor: '#fff', borderBottomWidth: 1, borderColor: '#eee' },
  title: { fontSize: 20, fontWeight: '700' },
  btn: { backgroundColor: '#4CAF50', paddingVertical: 8, paddingHorizontal: 12, borderRadius: 6 },
  btnText: { color: '#fff', fontWeight: '600' },
  item: { backgroundColor: '#fff', padding: 12, borderRadius: 8, flexDirection: 'row', alignItems: 'center' },
  itemTitle: { fontSize: 16, fontWeight: '700' },
  itemSubtitle: { fontSize: 12, color: '#666' },
  smallBtn: { paddingHorizontal: 8, paddingVertical: 6, backgroundColor: '#777', borderRadius: 6, marginLeft: 8 },
  smallBtnText: { color: '#fff', fontSize: 12 },
  modalOverlay: { flex: 1, backgroundColor: 'rgba(0,0,0,0.4)', justifyContent: 'center', padding: 20 },
  modalContent: { backgroundColor: '#fff', padding: 16, borderRadius: 8 },
  modalTitle: { fontSize: 18, fontWeight: '700', marginBottom: 8 },
  input: { borderWidth: 1, borderColor: '#ddd', padding: 10, borderRadius: 6, marginBottom: 12 }
});
