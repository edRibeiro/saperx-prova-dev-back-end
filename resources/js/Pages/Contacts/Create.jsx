import { router } from '@inertiajs/react';
import React, { useState } from 'react';

export default function Create() {
  const [values, setValues] = useState({ // Form fields
    name: "",
    email: "",
    birth_date: "",
    phones: [""]
  });

  // Adiciona um novo campo para telefone
  function addPhoneField() {
    setValues(values => ({
      ...values,
      phones: [...values.phones, ""]
    }));
  }

  // Atualiza o estado quando um campo de telefone é alterado
  function handlePhoneChange(index, e) {
    const newPhones = [...values.phones];
    newPhones[index] = e.target.value;
    setValues(values => ({
      ...values,
      phones: newPhones
    }));
  }

  // Atualiza o estado quando outros campos são alterados
  function handleChange(e) {
    const key = e.target.id;
    const value = e.target.value;
    setValues(values => ({
      ...values,
      [key]: value,
    }));
  }

  // Envia os dados do formulário para a rota de criação de contatos
  function handleSubmit(e) {
    e.preventDefault();
    router.post('/contacts', values);
  }

  return (
    <>
      <h1>Create Contact</h1>
      <hr />
      <form onSubmit={handleSubmit}>
        <label htmlFor="name">Name:</label>
        <input id="name" type="text" value={values.name} onChange={handleChange} />

        <label htmlFor="email">Email:</label>
        <input id="email" type="email" value={values.email} onChange={handleChange} />

        <label htmlFor="birth_date">Birth Date:</label>
        <input id="birth_date" type="date" value={values.birth_date} onChange={handleChange} />

        <label>Phones:</label>
        {values.phones.map((phone, index) => (
          <div key={index}>
            <input
              type="text"
              value={phone}
              onChange={(e) => handlePhoneChange(index, e)}
            />
          </div>
        ))}
        <button type="button" onClick={addPhoneField}>Add Phone</button>

        <button type="submit">Create</button>
      </form>
    </>
  );
}
