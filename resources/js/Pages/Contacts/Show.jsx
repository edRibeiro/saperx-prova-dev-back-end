export default function Show({ contact }) {
  return (
    <>
      <h1>{contact.name}</h1>
      <hr />
      <p><strong>Email:</strong> {contact.email}</p>
      <p><strong>Data de Nascimento:</strong> {new Date(contact.birth_date).toLocaleDateString()}</p>
      <p><strong>Telefones:</strong></p>
      <ul>
        {contact.phones.map((phone, index) => (
          <li key={index}>{phone}</li>
        ))}
      </ul>
    </>
  )
}
