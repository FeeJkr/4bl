import axios from "axios";
import {periodCategoriesDictionary as dictionary} from "../../../helpers/routes/finances/budgets/periodCategories.dictionary";

export const periodCategoriesService = {
    getAll,
};

function getAll(periodId) {
    return axios
        .get(dictionary.GET_ALL_URL.replace('{periodId}', periodId))
        .then((response) => response.data);
}
