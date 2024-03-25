import { router } from '@inertiajs/react';
import React, { useState } from 'react';

export default function Edit({ contact }) {
  const [values, setValues] = useState({ // Form fields
    name: contact.name,
    email: contact.email,
    birth_date: contact.birth_date,
    phones: contact.phones
  });

  function handleChange(e) {
    const key = e.target.id;
    const value = e.target.value;
    setValues(values => ({
      ...values,
      [key]: value,
    }));
  }

  function handlePhoneChange(index, e) {
    const newPhones = [...values.phones];
    newPhones[index] = e.target.value;
    setValues(values => ({
      ...values,
      phones: newPhones
    }));
  }

  function handleSubmit(e) {
    e.preventDefault();
    router.put(`/contacts/${contact.id}`, values);
  }

  return (
    <>
      <h1>Edit Contact</h1>
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
        <button type="submit">Update</button>
      </form>
    </>
  );
}
