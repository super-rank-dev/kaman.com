import { routes } from './leadinConfig';

const urlsMap: {
  [key: string]: any;
} = {};

Object.keys(routes).forEach(key => {
  const keyValue = routes[key];
  if (typeof keyValue === 'object') {
    Object.keys(keyValue).forEach(subkey => {
      urlsMap[key + subkey] = [keyValue, keyValue[subkey]];
    });
  } else {
    urlsMap[key] = keyValue;
  }
});

export default urlsMap;
