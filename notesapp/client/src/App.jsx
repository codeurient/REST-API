import './App.css'

import { gql } from "@apollo/client";
import { useQuery } from "@apollo/client/react";

const NOTES = gql`
  query getNotes {
    notes {
      id
      description
      title
      author {
        id
        name
        age
        photo
      }
    }
  }`;

function App() {

  const { loading, error, data } = useQuery(NOTES);
  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error : {error.message}</p>;

return data.notes.map(({ id, description, title, author }) => (
    <div key={id}>
      <h3>{title}</h3>
      <br/>
      <p><b>About this location:</b> {description}</p>
      <img width="400" height="250" alt="location-reference" src={`${author.photo}`} />
      <br />
    </div>
  ));
}

export default App
