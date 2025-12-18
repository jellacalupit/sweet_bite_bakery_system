import { render } from "@testing-library/react";
import App from "./App";

// App depends on AuthContext; for this smoke test we mock it to avoid needing a backend/token.
jest.mock("./context/AuthContext", () => ({
  useAuth: () => ({ loading: false, user: null }),
}));

test("renders without crashing", () => {
  render(<App />);
});
